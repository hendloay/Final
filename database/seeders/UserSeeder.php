<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'أحمد',
            'email' => 'ahmed.user@.com',
            'password' => Hash::make('123456789'),
        ]);

        User::create([
            'name' => 'سارة',
            'email' => 'sara.pro@.com',
            'password' => Hash::make('123456789'),
        ]);

        User::create([
            'name' => 'تامر',
            'email' => 'tamer.admin@.com',
            'password' => Hash::make('123456789'),
        ]);
    }
}