<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Database\Seeders\UsersTableSeeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            EventSeeder::class,
            TicketSeeder::class,   
            UsersTableSeeder::class, 
        ]);
    }
}
