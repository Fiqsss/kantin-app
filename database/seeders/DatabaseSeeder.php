<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Cart;
use App\Models\Menu;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Menu::create([
            'name' => 'Semur Jengkol',
            'price' => 15000,
            'foto' => 'Sjengkol.jpg',
            'keterangan' => 'isi ayang dengan jengkol',
        ]);
        Menu::create([
            'name' => 'Nasi Goreng',
            'price' => 12000,
            'foto' => 'Ngoreng.jpg',
            'keterangan' => 'isi telur dan ayam',

        ]);
        Menu::create([
            'name' => 'Sate',
            'price' => 20000,
            'foto' => 'sate.jpg',
            'keterangan' => 'saus kacang',

        ]);
        Menu::create([
            'name' => 'Mie Ayam',
            'price' => 15000,
            'foto' => 'Mayam.jpg',
            'keterangan' => 'tambahan bakso',

        ]);
        Menu::create([
            'name' => 'Nasi Gandul',
            'price' => 15000,
            'foto' => 'Ngandul.jpg',
            'keterangan' => 'isi hati sapi',
        ]);

        Cart::create([
            'menu_id' => 1,
            'qty' => 3,
            'total' => 30000,
        ]);
    }
}
