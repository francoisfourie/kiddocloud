<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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

                //call other seeds
        // $this->call([
        //     UserSeeder::class,
        //     PostSeeder::class,
        //     CommentSeeder::class,
        // ]);

        $companyUuid = 'd4debc65-e41c-47c2-9a57-2aede9b72091';


        DB::table('companies')->insert([
            'id' => $companyUuid,
            'name' => 'Lofkleuters',
            'email' => 'school@gmail.com',
            'phone' => '78979789',
            'address' => '12 Long',
            'owner' => 'Yolanda',
            
        ]);

        DB::table('employees')->insert([
            'id' => 'ab1243fe-8970-4e3c-aabd-323a7a41ec53',
            'name' => 'Nadia',
            'surname' => 'Marais',
            'phone' => '78979789',
            'address' => '12 Long',
            'email' => 'employee@gmail.com',
            'dob' => '1980-10-10',
            'emergency_contact_name' => 'Pieter',
            'emergency_contact_phone' => '456456455',
            'employee_type_id' => '2',
            'company_id' => $companyUuid,
        ]);

        DB::table('employees')->insert([
            'id' => '6d10a4e7-a865-4ee1-ace4-2c77fd7a4e3f',
            'name' => 'Martha',
            'surname' => 'Reneke',
            'phone' => '435646',
            'address' => '19 Short',
            'email' => 'employee12@gmail.com',
            'dob' => '1981-10-10',
            'emergency_contact_name' => 'Johan',
            'emergency_contact_phone' => '4564456455',
            'employee_type_id' => '2',
            'company_id' => $companyUuid,
        ]);

        DB::table('employees')->insert([
            'id' => 'ab1243fe-8970-4e3c-aabd-323a7a499999',
            'name' => 'noshow',
            'surname' => 'noshow',
            'phone' => '78979789',
            'address' => '12 Long',
            'email' => 'employee@gmail.com',
            'dob' => '1980-10-10',
            'emergency_contact_name' => 'Pieter',
            'emergency_contact_phone' => '456456455',
            'employee_type_id' => '2',
            'company_id' => 'invalid',
        ]);

        DB::table('leave_applications')->insert([
            'id' => 'd36f0d50-98f2-4d56-9aa4-bd8860abfd81',
            'company_id' => $companyUuid,
            'employee_id' => '6d10a4e7-a865-4ee1-ace4-2c77fd7a4e3f',
            'leave_type' => 'annual leave',
            'application_date' => '2023-11-12',
            'start_date' => '2023-11-20',
            'leave_days' => '1.00',
            'status' => 'approved',
        ]);

        DB::table('leave_applications')->insert([
            'id' => '6c81b2e0-7316-4cb3-baf4-02a914d3ab0a',
            'company_id' => $companyUuid,
            'employee_id' => '6d10a4e7-a865-4ee1-ace4-2c77fd7a4e3f',
            'leave_type' => 'annual leave',
            'application_date' => '2023-11-12',
            'start_date' => '2023-11-24',
            'leave_days' => '2.00',
            'status' => 'approved',
        ]);

        DB::table('leave_applications')->insert([
            'id' => 'adb48266-649a-43f4-9f2d-13973b4b34b6',
            'company_id' => $companyUuid,
            'employee_id' => '6d10a4e7-a865-4ee1-ace4-2c77fd7a4e3f',
            'leave_type' => 'sick leave',
            'application_date' => '2023-10-01',
            'start_date' => '2023-10-01',
            'leave_days' => '3.00',
            'status' => 'approved',
        ]);

        DB::table('leave_applications')->insert([
            'id' => '3663d58c-59d9-475c-9ab2-f32417fcf1ee',
            'company_id' => $companyUuid,
            'employee_id' => 'ab1243fe-8970-4e3c-aabd-323a7a41ec53',
            'leave_type' => 'sick leave',
            'application_date' => '2023-10-01',
            'start_date' => '2023-10-01',
            'leave_days' => '3.00',
            'status' => 'approved',
        ]);

        DB::table('users')->insert([
            'name' => 'yolanda',
            'email' => 'yolanda@lofkleuters.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // password
            'company_id' => $companyUuid,

        ]);

        DB::table('children')->insert([
            'id' => '313eb7a8-82fa-45d0-af81-a0aba104348c',
            'first_name' => 'Saartjie',
            'surname' => 'Bosman',
            'date_of_birth' => '2020-11-11',
            'id_number' => '201111000000000',
            'gender' => 'female',
            'home_language' => 'afrikaans',
            'company_id' => $companyUuid,
            'class_group_id' => '49e9fac4-200f-49cf-8b95-e20e1099f595',
        ]);

        DB::table('children')->insert([
            'id' => 'a2f67d7e-392f-4044-8595-d5470f845d7a',
            'first_name' => 'Johnny',
            'surname' => 'Walker',
            'date_of_birth' => '2020-10-11',
            'id_number' => '201234000000000',
            'gender' => 'male',
            'home_language' => 'english',
            'company_id' => $companyUuid,
            'class_group_id' => '49e9fac4-200f-49cf-8b95-e20e1099f595',
        ]);

        DB::table('guardians')->insert([
            'id' => 'e589a38a-2697-4738-935a-1a32cd766544',
            'first_name' => 'Susan',
            'surname' => 'Bosman',
            'title' => 'Ms',
            'relation' => 'mother',
            'id_number' => '850614000000000',
            'gender' => 'female',
            'address' => '12 brackenstreet brackenfell',
            'phone' => '0847787878',
            'email' => 'susanbosman@gmail.com',
            'company_id' => $companyUuid,
        ]);

        DB::table('guardians')->insert([
            'id' => '5eb07850-480a-4b9b-b98d-c274ff52c5a6',
            'first_name' => 'Marco',
            'surname' => 'Bosman',
            'title' => 'Mr',
            'relation' => 'father',
            'id_number' => '851014000000000',
            'gender' => 'male',
            'address' => '12 brackenstreet brackenfell',
            'phone' => '0844465621',
            'email' => 'marcobosman@gmail.com',
            'company_id' => $companyUuid,
        ]);

        DB::table('child_guardian')->insert([
            'child_id' => '313eb7a8-82fa-45d0-af81-a0aba104348c',
            'guardian_id' => 'e589a38a-2697-4738-935a-1a32cd766544',
        ]);
        
        DB::table('child_guardian')->insert([
            'child_id' => '313eb7a8-82fa-45d0-af81-a0aba104348c',
            'guardian_id' => '5eb07850-480a-4b9b-b98d-c274ff52c5a6',
        ]);

        DB::table('employee_types')->insert([
            'descr' => 'Manager',
        ]);
        
        DB::table('employee_types')->insert([
            'descr' => 'Teacher',
        ]);

        DB::table('employee_types')->insert([
            'descr' => 'Assistant',
        ]);

        DB::table('employee_types')->insert([
            'descr' => 'General Worker',
        ]);

        DB::table('class_groups')->insert([
            'id' => '49e9fac4-200f-49cf-8b95-e20e1099f595',
            'company_id' => $companyUuid,
            'name' => 'Rooi klas',
            'teacher_id' => 'ab1243fe-8970-4e3c-aabd-323a7a41ec53'
        ]);
        
        DB::table('class_groups')->insert([
            'id' => '8e8d7e18-224c-433a-8658-e808491fdc42',
            'company_id' => '24dd698e-4cfd-4e16-b893-00c6a77c662d',
            'name' => 'No Show',
            'teacher_id' => 'ab1243fe-8970-4e3c-aabd-323a7a41ec53'
        ]);


        DB::table('payment_terms')->insert([
            'id' => '940b5565-fcfc-4e6e-8eb9-8b18ff86b98c',
            'company_id' => $companyUuid,
            'start_date' => '2023-10-01',
            'end_date' => '2023-10-31',
            'name' => '2023-10'
        ]);

        DB::table('payment_terms')->insert([
            'id' => 'ff3aea97-b7ae-41b9-9e28-52073984b5ff',
            'company_id' => $companyUuid,
            'start_date' => '2023-11-01',
            'end_date' => '2023-11-30',
            'name' => '2023-11'
        ]);

        DB::table('payment_terms')->insert([
            'id' => '2ab846ed-5e30-48bd-b45c-bea568554cd7',
            'company_id' => $companyUuid,
            'start_date' => '2023-12-01',
            'end_date' => '2023-12-31',
            'name' => '2023-12'
        ]);

        DB::table('received_payments')->insert([
            'id' => '1284ad38-f244-463f-b7ca-f7666a4984c8',
            'company_id' => $companyUuid,
            'child_id' => '313eb7a8-82fa-45d0-af81-a0aba104348c',
            'payment_term_id' => '940b5565-fcfc-4e6e-8eb9-8b18ff86b98c',
            'received_date' => '2023-10-02',
            'method' => 'cash',
            'amount' => '1500.00',
            'note' => ''
        ]);

        DB::table('received_payments')->insert([
            'id' => '6efe2182-c4d5-46b4-b040-4df5c7f498e2',
            'company_id' => $companyUuid,
            'child_id' => '313eb7a8-82fa-45d0-af81-a0aba104348c',
            'payment_term_id' => 'ff3aea97-b7ae-41b9-9e28-52073984b5ff',
            'received_date' => '2023-11-02',
            'amount' => '1500.00',
            'method' => 'card',
            'note' => ''
        ]);

        DB::table('received_payments')->insert([
            'id' => 'af7992db-2e53-478a-8d18-4e1284edae6d',
            'company_id' => $companyUuid,
            'child_id' => '313eb7a8-82fa-45d0-af81-a0aba104348c',
            'payment_term_id' => '2ab846ed-5e30-48bd-b45c-bea568554cd7',
            'received_date' => '2023-12-04',
            'amount' => '1500.00',
            'method' => 'eft',
            'note' => ''
        ]);
        // Company::factory()
        //     ->count(50)
        //     ->create();


    }
}
