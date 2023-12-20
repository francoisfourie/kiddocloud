<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('employeeType')->insert([
            'descr' => 'Manager',
        ]);
        
        DB::table('employeeType')->insert([
            'descr' => 'Teacher',
        ]);

        DB::table('employeeType')->insert([
            'descr' => 'Assistant',
        ]);

        DB::table('employeeType')->insert([
            'descr' => 'General Worker',
        ]);
    }
}
