<?php

namespace Database\Seeders;

use App\Enums\StaffRole;
use App\Models\Course;
use App\Models\JobRole;
use App\Models\Staff;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin staff account
        Staff::firstOrCreate(
            ['email' => 'admin@aatmanirbhar.in'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => StaffRole::Admin,
                'phone' => '9999999999',
                'is_active' => true,
            ]
        );

        // Sample courses
        $courses = [
            ['name' => 'Digital Mitra', 'code' => 'DM', 'duration_months' => 3, 'fee' => 0, 'security_deposit_amount' => 1000],
            ['name' => 'Warehouse Supervisor', 'code' => 'WHS', 'duration_months' => 3, 'fee' => 0, 'security_deposit_amount' => 1000],
        ];

        foreach ($courses as $course) {
            Course::firstOrCreate(['code' => $course['code']], $course);
        }

        // Job roles
        $jobRoles = [
            'Digital Mitra',
            'Warehouse Supervisor',
            'Domestic Data Entry Operator',
        ];

        foreach ($jobRoles as $role) {
            JobRole::firstOrCreate(['name' => $role]);
        }
    }
}
