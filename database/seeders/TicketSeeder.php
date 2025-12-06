<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('tickets')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $talkshow = DB::table('events')->where('nama_event', 'Talkshow Inspiratif')->first();
        $tryout = DB::table('events')->where('nama_event', 'Tryout UTBK/SNBT')->first();

        if ($talkshow && $tryout) {
            $tickets = [
                [
                    'event_id' => $talkshow->event_id,
                    'jenis_tiket' => 'Talkshow Offline',
                    'harga' => 0,
                    'stok' => 150,
                    'created_at' => now(), 'updated_at' => now(),
                ],
                [
                    'event_id' => $talkshow->event_id,
                    'jenis_tiket' => 'Talkshow Online',
                    'harga' => 0,
                    'stok' => 99999,
                    'created_at' => now(), 'updated_at' => now(),
                ],

                [
                    'event_id' => $tryout->event_id,
                    'jenis_tiket' => 'Single',
                    'harga' => 40000, 
                    'stok' => 200, 
                    'created_at' => now(), 'updated_at' => now(),
                ],
                [
                    'event_id' => $tryout->event_id,
                    'jenis_tiket' => 'Couple',
                    'harga' => 75000,
                    'stok' => 50, 
                    'created_at' => now(), 'updated_at' => now(),
                ],
                [
                    'event_id' => $tryout->event_id,
                    'jenis_tiket' => 'Circle',
                    'harga' => 185000,
                    'stok' => 20, 
                    'created_at' => now(), 'updated_at' => now(),
                ]
            ];

            DB::table('tickets')->insert($tickets);
        }
    }
}