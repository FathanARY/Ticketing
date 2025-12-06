<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            [
                'event_id' => 1,
                'nama_event' => 'University Goes to School',
                'deskripsi' => 'Sosialisasi ke 50 sekolah yang berada di kota Bandung dengan tujuan memberikan informasi lengkap mengenai berbagai jalur masuk PTN. Mulai dari SNBP, SNBT, hingga jalur mandiri.',
                'tanggal_event' => '2025-10-01 09:00:00',
                'lokasi' => 'Bandung Raya',
                'maps_embed' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'event_id' => 2,
                'nama_event' => 'Talkshow Inspiratif',
                'deskripsi' => 'Sesi inspiratif dengan alumni PTN ternama dan mahasiswa berprestasi yang berbagi pengalaman nyata, strategi belajar efektif, dan tips mengatasi tantangan persiapan PTN.',
                'tanggal_event' => '2025-10-04 13:00:00',
                'lokasi' => 'Gedung Sate Bandung',
                'maps_embed' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'event_id' => 3,
                'nama_event' => 'Tryout UTBK/SNBT',
                'deskripsi' => 'Simulasi UTBK/SNBT lengkap dengan format resmi terbaru, mencakup TPS, Literasi, dan Penalaran Matematika. Dilengkapi analisis mendalam hasil tryout.',
                'tanggal_event' => '2025-10-05 08:00:00',
                'lokasi' => 'Online & Offline',
                'maps_embed' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($events as $event) {
            DB::table('events')->updateOrInsert(
                ['event_id' => $event['event_id']], // Check by event_id
                $event // Insert or update with this data
            );
        }
    }
}
