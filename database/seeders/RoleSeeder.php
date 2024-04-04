<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{

    public function run(): void
    {
        $role = 
        [
        [
            'name' => 'Admin' //1
        ],
        [
            'name' => 'User' //2
        ],
    ];
    Role::insert($role);
    }
}
