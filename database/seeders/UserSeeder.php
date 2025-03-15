<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'phone' => '+201226497712',
                'password' => Hash::make('123456'),
                'role' => 'admin',
            ],
            [
                'name' => 'Doctor Mohamed',
                'email' => 'doctor1@example.com',
                'phone' => '+201550533514',
                'password' => Hash::make('123456'),
                'role' => 'doctor',
            ],
            [
                'name' => 'Doctor Hamdy',
                'email' => 'doctor2@example.com',
                'phone' => '+201550533515',
                'password' => Hash::make('123456'),
                'role' => 'doctor',
            ],
            [
                'name' => 'Patient Sayed',
                'email' => 'patient2@example.com',
                'phone' => '+201226497711',
                'password' => Hash::make('123456'),
                'role' => 'patient',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
    
}