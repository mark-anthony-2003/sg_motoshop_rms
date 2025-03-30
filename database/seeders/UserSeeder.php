<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 5 employees
        User::factory()->count(10)->employee()->create();
        // Create 5 customers
        User::factory()->count(20)->customer()->create();
    }
}
