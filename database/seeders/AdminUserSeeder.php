<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Address;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'first_name' => 'admin',
            'last_name' => 'user',
            'email' => 'admin@example.com',
            'password' => Hash::make('adminadmin'),
            'date_of_birth' => '2003-04-19',
            'contact_no' => '00000000000',
            'user_type' => 'admin',
            'account_status' => 'active'
        ]);

        Address::create([
            'user_id' => $user->user_id,
            'address_type' => 'home',
            'barangay' => 'Binalay',
            'city' =>'Tinambac',
            'province' => 'Camarines Sur',
            'country' => 'Philippines'
        ]);
    }
}
