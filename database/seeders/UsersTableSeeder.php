<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'nama_lengkap' => 'Admin GTP',
                'email' => 'admin@gtp.com',
                'password' => Hash::make('password'),
                'email_verified_at' => '2025-11-15 03:59:14',
                'no_hp' => '081234567890',
                'school_name' => 'Panitia GTP',
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_lengkap' => 'User Biasa',
                'email' => 'user@gtp.com',
                'password' => Hash::make('password'),
                'email_verified_at' => '2025-11-15 03:59:14',
                'no_hp' => '089876543210',
                'school_name' => 'SMA Negeri 1 Bandung',
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
