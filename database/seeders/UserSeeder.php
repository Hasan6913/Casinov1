<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\StanjeRacuna;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Kreiranje admin korisnika
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'nekiadmin@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => 'admin',
        ]);

        // Kreiranje StanjeRacuna za admin korisnika
        $admin->stanjeRacuna()->create([
            'stanje' => 10000.00, // Početni iznos stanja
        ]);

        // Kreiranje korisnika "John Doe"
        $user1 = User::create([
            'name' => 'John Doe',
            'email' => 'john.doe2@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Kreiranje StanjeRacuna za "John Doe"
        $user1->stanjeRacuna()->create([
            'stanje' => 5000.00, // Početni iznos stanja
        ]);

        // Kreiranje 100 novih korisnika sa StanjeRacuna
        \App\Models\User::factory(100)->create()->each(function ($user) {
            // Kreiranje StanjeRacuna za svakog korisnika
            $user->stanjeRacuna()->create([
                'stanje' => rand(0, 10000), // Random balans za svakog korisnika
            ]);
        });
    }
}

