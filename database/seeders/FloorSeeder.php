<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Floor;

class FloorSeeder extends Seeder{

    public function run(): void {
        $floor =
        [
            [
                'name' => 'BF', //-1
            ],
            [
                'name' => 'GF', //0
            ],
            [
                'name' => '1stF', //1
            ],
            [
                'name' => '2ndF ', //2
            ],
            [
                'name' => '3rdF ', //3
            ],
            [
                'name' => '4thF  ', //4
            ]
        ];
        Floor::insert($floor);

    }
}

