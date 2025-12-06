<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Database\Seeders\UsersTableSeeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            EventSeeder::class,    // ← Run FIRST to create events
            TicketSeeder::class,   // ← Run SECOND to create tickets
            // UsersTableSeeder::class, // ← Uncomment when ready
        ]);
        $this->call(UsersTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
