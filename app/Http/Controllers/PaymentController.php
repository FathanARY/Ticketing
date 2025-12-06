<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Ticket;
use Midtrans\Config;
use Illuminate\Support\Facades\Mail;
use App\Mail\TalkshowRegistered;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
        
        // Disable SSL verification for local development
        // WARNING: Enable SSL verification in production!
        Config::$curlOptions = config('midtrans.curl_options', []);
    }

    public function selection()
    {
        return view('ticket.selection');
    }

    public function talkshowForm()
    {
        $tickets = Ticket::where('jenis_tiket', 'like', 'Talkshow%')->get();
        return view('ticket.talkshow', compact('tickets'));
    }

   public function talkshowSubmit(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'email' => 'required|email',
            'no_hp' => 'required',
            'school_name' => 'required',
            'jenis_tiket' => 'required'
        ]);

        $ticket = Ticket::where('jenis_tiket', $request->jenis_tiket)->first();

        if (!$ticket) {
            return back()->with('error', 'Jenis tiket tidak valid.');
        }

        if ($ticket->jenis_tiket == 'Talkshow Offline' && $ticket->stok <= 0) {
            return back()->with('error', 'Maaf, tiket Offline untuk Talkshow sudah habis. Silakan hubungi Admin atau daftar Online.');
        }

        $kodeTiket = 'TS-' . strtoupper(uniqid());

        DB::transaction(function () use ($ticket, $request, $kodeTiket) {
            $ticket->decrement('stok');

            $transaksiId = DB::table('transactions')->insertGetId([
                'user_id' => auth()->id(),
                'ticket_id' => $ticket->ticket_id,
                'jumlah_tiket' => 1,
                'total_harga' => 0,
                'status' => 'paid',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::table('user_tickets')->insert([
                'user_id' => auth()->id(),
                'transaksi_id' => $transaksiId,
                'kode_tiket' => $kodeTiket,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        });

        try {
            Mail::to($request->email)->send(new TalkshowRegistered([
                'nama_lengkap' => $request->nama_lengkap,
                'jenis_tiket' => $ticket->jenis_tiket,
                'kode_tiket' => $kodeTiket
            ])); 
            
        } catch (\Exception $e) {
           Log::error('Gagal kirim email: ' . $e->getMessage());
        }

        return redirect()->route('dashboard')->with('success', 'Berhasil mendaftar Talkshow! Tiket telah aktif.');
    }

    public function tryoutForm()
    {
        $tickets = Ticket::where('jenis_tiket', 'not like', 'Talkshow%')
                         ->where('stok', '>', 0)
                         ->get();

        $ticketBundles = $tickets->map(function($ticket) {
            return [
                'id' => $ticket->ticket_id,
                'type' => $ticket->jenis_tiket, 
                'name' => $ticket->jenis_tiket . " (Sisa: {$ticket->stok})",
                'price' => $ticket->harga,
                'is_free' => false,
                'icon' => 'single-icon.png' 
            ];
        });

        $paymentMethods = [
            ['type' => 'online', 'name' => 'Online Payment (QRIS/VA)', 'icon' => 'cash-icon.png'],
            ['type' => 'cash', 'name' => 'Cash / Transfer Manual', 'icon' => 'cash-icon.png']
        ];

        return view('ticket.dashboard', compact('ticketBundles', 'paymentMethods'));
    }

    public function order(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'phone' => 'required|string',
            'bundle' => 'required',
        ]);

        $ticket = Ticket::where('jenis_tiket', $request->bundle)->first();

        if (!$ticket) {
            return response()->json(['error' => 'Tiket tidak ditemukan'], 400);
        }

        if ($ticket->stok <= 0) {
            return response()->json(['error' => 'Tiket habis'], 400);
        }

        $grossAmount = (int) $ticket->harga;

        // Handle FREE ticket
        if ($grossAmount <= 0) {
            $orderId = 'GTP-FREE-' . time() . '-' . rand(1000, 9999);
            $kodeTiket = 'TO-' . strtoupper(uniqid());

            DB::transaction(function () use ($ticket, $request, $kodeTiket) {
                $ticket->decrement('stok');

                $transaksiId = DB::table('transactions')->insertGetId([
                    'user_id' => auth()->id(),
                    'ticket_id' => $ticket->ticket_id,
                    'jumlah_tiket' => 1,
                    'total_harga' => 0,
                    'status' => 'paid',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                DB::table('user_tickets')->insert([
                    'user_id' => auth()->id(),
                    'transaksi_id' => $transaksiId,
                    'kode_tiket' => $kodeTiket,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            });

            return response()->json([
                'is_free' => true,
                'status' => 'free_success',
                'message' => 'Tiket gratis berhasil diklaim!',
                'order_id' => $orderId,
                'kode_tiket' => $kodeTiket
            ]);
        }

        // Payment method required for paid tickets
        if (!$request->payment) {
            return response()->json(['error' => 'Pilih metode pembayaran'], 400);
        }

        $orderId = 'GTP-' . time() . '-' . rand(1000, 9999);

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $grossAmount,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->nama_lengkap,
                'email' => $request->email,
                'phone' => $request->phone,
            ],
            'item_details' => [
                [
                    'id' => (string) $ticket->ticket_id,
                    'price' => $grossAmount,
                    'quantity' => 1,
                    'name' => substr($ticket->jenis_tiket, 0, 50) // Max 50 chars for item name
                ]
            ]
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return response()->json([
                'snap_token' => $snapToken,
                'order_id' => $orderId,
                'bundle_name' => $ticket->jenis_tiket,
                'amount' => $grossAmount
            ]);
        } catch (\Exception $e) {
            Log::error('Midtrans Error: ' . $e->getMessage(), [
                'params' => $params,
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Gagal memproses pembayaran: ' . $e->getMessage()], 500);
        }
    }

    public function cashPrepare(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'phone' => 'required|string',
            'bundle' => 'required'
        ]);

        $ticket = Ticket::where('jenis_tiket', $request->bundle)->first();

        if (!$ticket) {
            return back()->withErrors(['bundle' => 'Tiket tidak valid']);
        }

        $orderId = 'GTP-CASH-' . time() . '-' . rand(1000, 9999);

        $orderData = [
            'order_id' => $orderId,
            'bundle_type' => $ticket->jenis_tiket,
            'ticket_id' => $ticket->ticket_id,
            'bundle_name' => $ticket->jenis_tiket,
            'amount' => $ticket->harga,
            'email' => $request->email,
            'phone' => $request->phone
        ];

        return view('ticket.cash-payment', compact('orderData'));
    }

    public function cashSubmit(Request $request)
    {
        $request->validate([
            'order_id' => 'required|string',
            'bundle' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'amount' => 'required|numeric',
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:5120'
        ]);

        try {
            $file = $request->file('payment_proof');

            // Create directory
            $directory = storage_path('app' . DIRECTORY_SEPARATOR . 'payment-proofs');
            if (!is_dir($directory)) {
                mkdir($directory, 0777, true);
            }

            // Generate unique filename
            $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $fullPath = $directory . DIRECTORY_SEPARATOR . $filename;

            // Manually move the file
            $moved = move_uploaded_file($file->getRealPath(), $fullPath);

            if (!$moved || !file_exists($fullPath)) {
                throw new \Exception('Failed to move uploaded file to: ' . $fullPath);
            }

            // Store relative path with forward slashes (cross-platform)
            $relativePath = 'payment-proofs/' . $filename;

            \Log::info('File saved successfully', [
                'filename' => $filename,
                'full_path' => $fullPath,
                'relative_path' => $relativePath,
                'size' => filesize($fullPath)
            ]);

            $paymentId = DB::table('cash_payments')->insertGetId([
                'user_id' => auth()->id(),
                'order_id' => $request->order_id,
                'bundle_type' => $request->bundle,
                'email' => $request->email,
                'phone' => $request->phone,
                'amount' => $request->amount,
                'payment_proof_path' => $relativePath,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Bukti pembayaran berhasil diupload',
                'payment_id' => $paymentId
            ]);
        } catch (\Exception $e) {
            \Log::error('Upload failed', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupload: ' . $e->getMessage()
            ], 500);
        }
    }

    public function cashPending()
    {
        return view('ticket.payment-pending');
    }

    public function userTicketProof($payment_id)
    {
        $payment = DB::table('cash_payments')
            ->where('payment_id', $payment_id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$payment) abort(404);

        $path = storage_path('app/' . $payment->payment_proof_path);
        
        if (!file_exists($path)) abort(404);

        return response()->file($path);
    }
}

