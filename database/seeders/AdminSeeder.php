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
        $admin = User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'user_type' => 'admin',
            'password' => Hash::make('password'), // Securely hash password
        ]);

        // Create a Sanctum token for the admin user

        // $token = $admin->createToken('admin-token')->plainTextToken;
        //  // Optional: print or log the token
        //  echo "Admin Sanctum Token: $token\n";
    }
}
