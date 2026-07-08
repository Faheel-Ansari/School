<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            //superadmin
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@gmail.com',
                'password' => Hash::make('superadmin123'),
                'role' => 'superadmin',
            ],
        ]);
        $user = User::where('role','superadmin')->first();
        DB::table('superadmin_profile')->insert([
            //superadmin profile
            [
                'role_id' => $user->id,
            ],
        ]);
    }
}