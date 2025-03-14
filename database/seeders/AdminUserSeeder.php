<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@exemplo.com',
            'password' => Hash::make('12345678'), // Senha criptografada
            'is_admin' => true, // Define como administrador
            'is_producer' => true,
            'phone_number' => '987654321',
            'email_verified_at' => now(),
            'is_seeder' => true,
        ]);

        // Criar um produtor de escala
        User::create([
            'name' => 'Produtor',
            'email' => 'produtor@example.com',
            'password' => bcrypt('password'),
            'is_admin' => false,
            'is_producer' => true,
            'phone_number' => '987654321',
            'email_verified_at' => now(),
            'is_seeder' => true,
        ]);
    }
}