<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Vérifie si l'utilisateur existe déjà
        if (!User::where('email', 'papamaman@gmail.com')->exists()) {
            User::create([
                'name' => 'BM-Service',
                'email' => 'papamaman@gmail.com',
                'role' => 'super_admin',
                'password' => Hash::make('password123'),
                'plain_password' => 'password123', // ⚠️ doit exister dans ta table
            ]);
        }
    }
}
