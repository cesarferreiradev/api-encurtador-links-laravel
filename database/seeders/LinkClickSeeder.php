<?php

namespace Database\Seeders;

use App\Models\LinkClick;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LinkClickSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LinkClick::factory()->create();
    }
}
