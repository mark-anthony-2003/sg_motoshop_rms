<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            AdminUserSeeder::class,
            UserSeeder::class,
            ItemSeeder::class,
            PositionTypeSeeder::class,
            SalaryTypeSeeder::class,
            EmployeeSeeder::class,
            ManagerTypeSeeder::class,
            LaborerTypeSeeder::class,
            ServiceTypeSeeder::class,
            PartSeeder::class
        ]);
    }
}
