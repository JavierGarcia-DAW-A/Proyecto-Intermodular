<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HairdresserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Hairdresser::create(['name' => 'Guy C. Pulido bks']);
        \App\Models\Hairdresser::create(['name' => 'Steve L. Nolan']);
        \App\Models\Hairdresser::create(['name' => 'Edgar P. Mathis']);
    }
}
