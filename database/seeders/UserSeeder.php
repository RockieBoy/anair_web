<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Superadmin
        User::create([
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'password' => Hash::make('12345'),
            'role' => 'superadmin',
        ]);

        // Admin
        User::create([
            'name' => 'Admin Gudang',
            'username' => 'admin',
            'password' => Hash::make('12345'),
            'role' => 'admin',
        ]);

        // Karyawan
        User::create([
            'name' => 'Karyawan',
            'username' => 'karyawan',
            'password' => Hash::make('12345'),
            'role' => 'karyawan',
        ]);
    }
}
