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
        ]);
    }
}