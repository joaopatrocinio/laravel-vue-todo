<?php

namespace Database\Seeders;

use App\Enums\StatusEnum;
use App\Models\Status;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        foreach (StatusEnum::cases() as $status) {
            Status::create(['status' => strtolower($status->name)]);
        }
    }
}
