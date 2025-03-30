<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\PositionType;
use App\Models\SalaryType;
use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultSalary = SalaryType::where('salary_type_name', 'per_day')->value('salary_type_id');
        $laborerPosition = PositionType::where('position_type_name', 'laborer')->value('position_type_id');
        $managerPosition = PositionType::where('position_type_name', 'manager')->value('position_type_id');

        $employees = User::where('user_type', 'employee')->get();

        if ($employees->isEmpty()) {
            return;
        }

        // Assign the first employee as a manager
        $firstEmployee = $employees->shift();
        Employee::updateOrCreate(
            ['user_id' => $firstEmployee->user_id],
            [
                'service_transaction_id' => null,
                'salary_type_id'         => $defaultSalary,
                'position_type_id'       => $managerPosition,
                'date_hired'             => now(),
            ]
        );

        // Assign the rest as laborers
        foreach ($employees as $user) {
            Employee::updateOrCreate(
                ['user_id' => $user->user_id],
                [
                    'service_transaction_id' => null,
                    'salary_type_id'         => $defaultSalary,
                    'position_type_id'       => $laborerPosition,
                    'date_hired'             => now(),
                ]
            );
        }
    }
}
