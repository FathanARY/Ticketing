<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = DB::table('tickets')
            ->join('events', 'tickets.event_id', '=', 'events.event_id')
            ->select('tickets.*', 'events.nama_event')
            ->orderBy('tickets.ticket_id', 'desc')
            ->get();

        $events = DB::table('events')->pluck('nama_event', 'event_id');

        return view('admin.tickets.index', compact('tickets', 'events'));
    }

    public function create()
    {
        $events = DB::table('events')->pluck('nama_event', 'event_id');
        return view('admin.tickets.index', compact('events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,event_id',
            'jenis_tiket' => 'required|string|max:100',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
        ]);

        DB::table('tickets')->insert([
            'event_id' => $request->event_id,
            'jenis_tiket' => $request->jenis_tiket,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.tickets.index')->with('success', 'Tiket berhasil ditambahkan.');
    }

    public function edit($ticket_id)
    {
        $ticket = DB::table('tickets')->where('ticket_id', $ticket_id)->first();
        if (!$ticket) {
            abort(404);
        }

        $events = DB::table('events')->pluck('nama_event', 'event_id');
        $tickets = DB::table('tickets')
            ->join('events', 'tickets.event_id', '=', 'events.event_id')
            ->select('tickets.*', 'events.nama_event')
            ->orderBy('tickets.ticket_id', 'desc')
            ->get();

        return view('admin.tickets.index', compact('ticket', 'events', 'tickets'));
    }

    public function update(Request $request, $ticket_id)
    {
        $request->validate([
            'event_id' => 'required|exists:events,event_id',
            'jenis_tiket' => 'required|string|max:100',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
        ]);

        DB::table('tickets')
            ->where('ticket_id', $ticket_id)
            ->update([
                'event_id' => $request->event_id,
                'jenis_tiket' => $request->jenis_tiket,
                'harga' => $request->harga,
                'stok' => $request->stok,
                'updated_at' => now(),
            ]);

        return redirect()->route('admin.tickets.index')->with('success', 'Tiket berhasil diperbarui.');
    }

    public function destroy($ticket_id)
    {
        DB::table('tickets')->where('ticket_id', $ticket_id)->delete();
        return redirect()->route('admin.tickets.index')->with('success', 'Tiket berhasil dihapus.');
    }
}
