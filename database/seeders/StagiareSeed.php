<?php

namespace Database\Seeders;

use App\Models\Stagiaires;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StagiareSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Stagiaires::factory()->count(30)->create();
    }
}
