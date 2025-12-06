<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    // Hanya Menampilkan Daftar Event
    public function index()
    {
        // Urutkan berdasarkan ID agar urutannya tetap (UGS -> Talkshow -> Tryout)
        $events = DB::table('events')->orderBy('event_id', 'asc')->get();
        return view('admin.events.index', compact('events'));
    }

    // Hanya Menampilkan Form Edit
    public function edit($event_id)
    {
        $event = DB::table('events')->where('event_id', $event_id)->first();
        if (!$event) abort(404);
        
        // Kita tetap butuh list events untuk sidebar/tabel di bawah form (opsional)
        $events = DB::table('events')->orderBy('event_id', 'asc')->get();
        
        return view('admin.events.index', compact('event', 'events'));
    }

    // Hanya Menyimpan Perubahan (Update)
    public function update(Request $request, $event_id)
    {
        $request->validate([
            'nama_event' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_event' => 'required|date',
            'lokasi' => 'required|string|max:255',
            'maps_embed' => 'nullable|string',
        ]);

        DB::table('events')
            ->where('event_id', $event_id)
            ->update([
                'nama_event' => $request->nama_event,
                'deskripsi' => $request->deskripsi,
                'tanggal_event' => $request->tanggal_event,
                'lokasi' => $request->lokasi,
                'maps_embed' => $request->maps_embed,
                'updated_at' => now(),
            ]);

        return redirect()->route('admin.events.index')->with('success', 'Data Event berhasil diperbarui.');
    }

    // HAPUS function create(), store(), dan destroy() agar Admin tidak bisa akses.
}