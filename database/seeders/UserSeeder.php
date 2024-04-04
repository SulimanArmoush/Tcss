<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;


class UserSeeder extends Seeder{

    public function run(): void{

        $user =
        [
            [
                'name' => 'admin', //1
                'password' => Hash::make('adminadmin'),
                'role_id' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];
        User::insert($user);

    }
}
