<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id'    => 1,
            'name'  => 'Admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('1234567890'),
            'phone'    => '0945678321',
            'address'  => 'almazeh',
            'role'     => 'admin',
            'status'   => 1,
            'gender'   => 'male',
            'has_residence' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
