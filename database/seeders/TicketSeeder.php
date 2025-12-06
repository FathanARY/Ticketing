<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        $talkshow = DB::table('events')->where('nama_event', 'Talkshow Inspiratif')->first();
        $tryout = DB::table('events')->where('nama_event', 'Tryout UTBK/SNBT')->first();

        if ($talkshow && $tryout) {
            $tickets = [
                [
                    'event_id' => $talkshow->event_id,
                    'jenis_tiket' => 'Talkshow Offline',
                    'harga' => 0,
                    'stok' => 150,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'event_id' => $talkshow->event_id,
                    'jenis_tiket' => 'Talkshow Online',
                    'harga' => 0,
                    'stok' => 99999,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'event_id' => $tryout->event_id,
                    'jenis_tiket' => 'Single',
                    'harga' => 40000,
                    'stok' => 200,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'event_id' => $tryout->event_id,
                    'jenis_tiket' => 'Couple',
                    'harga' => 75000,
                    'stok' => 50,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'event_id' => $tryout->event_id,
                    'jenis_tiket' => 'Circle',
                    'harga' => 185000,
                    'stok' => 20,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            foreach ($tickets as $ticket) {
                DB::table('tickets')->updateOrInsert(
                    [
                        'event_id' => $ticket['event_id'],
                        'jenis_tiket' => $ticket['jenis_tiket']
                    ], // Check by event_id AND jenis_tiket
                    $ticket // Insert or update with this data
                );
            }
        }
    }
}
