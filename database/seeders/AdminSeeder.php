<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        //// add admin 
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'user_type'=>'admin',
            'password' => Hash::make('password'), // Securely hash password
        ]);
    }
}
