<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {


        Position::create(['name' => 'Security']);
        Position::create(['name' => 'Manager']);
        Position::create(['name' => 'Seller']);

        User::factory(45)->create();
    }
}
