<?php

namespace Database\Seeders;

use App\Enums\StatusEnum;
use App\Models\Status;
use App\Models\Task;
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
            Status::create([
                'id' => $status->value,
                'status' => $status->name
            ]);
        }

        Task::create([
            'title' => 'Seeder',
            'status_id' => 1
        ]);
    }
}
