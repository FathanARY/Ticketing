<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentApprovedMail;

class CashPaymentController extends Controller
{
    /**
     * Display list of cash payments
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'pending');

        // Get counts for each status
        $pendingCount = DB::table('cash_payments')
            ->where('status', 'pending')
            ->count();

        $approvedCount = DB::table('cash_payments')
            ->where('status', 'approved')
            ->count();

        $rejectedCount = DB::table('cash_payments')
            ->where('status', 'rejected')
            ->count();

        $totalCount = DB::table('cash_payments')->count();

        // Build query
        $query = DB::table('cash_payments')
            ->join('users', 'cash_payments.user_id', '=', 'users.user_id')
            ->leftJoin('users as approvers', 'cash_payments.approved_by', '=', 'approvers.user_id')
            ->select(
                'cash_payments.*',
                'users.nama_lengkap',
                'approvers.nama_lengkap as approved_by_name'
            )
            ->orderBy('cash_payments.created_at', 'desc');

        // Filter by status
        if ($status !== 'all') {
            $query->where('cash_payments.status', $status);
        }

        $payments = $query->paginate(12)->appends(['status' => $status]);

        return view('admin.cash-payments', compact(
            'payments',
            'pendingCount',
            'approvedCount',
            'rejectedCount',
            'totalCount'
        ));
    }

    /**
     * Show payment proof image
     */
    /**
     * Show payment proof image
     */
    /**
     * Show payment proof image
     */
    public function showProof($payment_id)
    {
        $payment = DB::table('cash_payments')
            ->where('payment_id', $payment_id)
            ->first();

        if (!$payment) {
            abort(404, 'Payment not found');
        }

        // Build path using consistent directory separators
        $storagePath = storage_path('app');
        $relativePath = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $payment->payment_proof_path);
        $fullPath = $storagePath . DIRECTORY_SEPARATOR . $relativePath;

        \Log::info('Payment Proof Access', [
            'payment_id' => $payment_id,
            'stored_db_path' => $payment->payment_proof_path,
            'storage_base' => $storagePath,
            'relative_path' => $relativePath,
            'full_path' => $fullPath,
            'file_exists' => file_exists($fullPath),
            'directory_exists' => is_dir(dirname($fullPath))
        ]);

        if (!file_exists($fullPath)) {
            \Log::error('Payment proof file not found', [
                'payment_id' => $payment_id,
                'expected_path' => $fullPath,
                'directory_contents' => is_dir(dirname($fullPath)) ? scandir(dirname($fullPath)) : 'Directory not found'
            ]);

            abort(404, 'Payment proof file not found. Path: ' . $fullPath);
        }

        $mimeType = mime_content_type($fullPath);

        return response()->file($fullPath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . basename($fullPath) . '"'
        ]);
    }

    /**
     * Approve a cash payment
     */
    public function approve($payment_id)
    {
        try {
            $payment = DB::table('cash_payments')
                ->join('users', 'cash_payments.user_id', '=', 'users.user_id')
                ->select('cash_payments.*', 'users.nama_lengkap', 'users.email as user_email')
                ->where('cash_payments.payment_id', $payment_id)
                ->first();

            if (!$payment) {
                return redirect()->back()->withErrors('Pembayaran tidak ditemukan.');
            }

            if ($payment->status !== 'pending') {
                return redirect()->back()->withErrors('Pembayaran sudah diproses sebelumnya.');
            }

            // Update payment status
            DB::table('cash_payments')
                ->where('payment_id', $payment_id)
                ->update([
                    'status' => 'approved',
                    'approved_by' => Auth::id(),
                    'approved_at' => now(),
                    'updated_at' => now()
                ]);

            // Create notification for user
            DB::table('notifications')->insert([
                'user_id' => $payment->user_id,
                'jenis_notif' => 'payment_approved',
                'status' => 'unread',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Send email to user
            try {
                Mail::to($payment->email)->send(new PaymentApprovedMail($payment, $payment->nama_lengkap));
                \Log::info('Approval email sent successfully', [
                    'payment_id' => $payment_id,
                    'email' => $payment->email
                ]);
            } catch (\Exception $emailError) {
                \Log::error('Failed to send approval email', [
                    'payment_id' => $payment_id,
                    'email' => $payment->email,
                    'error' => $emailError->getMessage()
                ]);
                // Continue even if email fails - payment is still approved
            }

            return redirect()->back()->with('success', 'Pembayaran berhasil disetujui dan email telah dikirim.');
        } catch (\Exception $e) {
            \Log::error('Payment approval failed', [
                'payment_id' => $payment_id,
                'error' => $e->getMessage()
            ]);
            return redirect()->back()->withErrors('Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Reject a cash payment
     */
    public function reject(Request $request, $payment_id)
    {
        $request->validate([
            'admin_notes' => 'required|string|max:500'
        ]);

        try {
            $payment = DB::table('cash_payments')
                ->where('payment_id', $payment_id)
                ->first();

            if (!$payment) {
                return redirect()->back()->withErrors('Pembayaran tidak ditemukan.');
            }

            if ($payment->status !== 'pending') {
                return redirect()->back()->withErrors('Pembayaran sudah diproses sebelumnya.');
            }

            // Update payment status
            DB::table('cash_payments')
                ->where('payment_id', $payment_id)
                ->update([
                    'status' => 'rejected',
                    'admin_notes' => $request->admin_notes,
                    'approved_by' => Auth::id(),
                    'approved_at' => now(),
                    'updated_at' => now()
                ]);

            // Create notification for user
            DB::table('notifications')->insert([
                'user_id' => $payment->user_id,
                'jenis_notif' => 'payment_rejected',
                'status' => 'unread',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // TODO: Send email notification
            // Mail::to($payment->email)->send(new PaymentRejectedMail($payment, $request->admin_notes));

            return redirect()->back()->with('success', 'Pembayaran berhasil ditolak.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
