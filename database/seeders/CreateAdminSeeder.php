<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\role;

class CreateAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        User::create([
            'email' => 'admin@mail.ru',
            'name' => 'Admin',
            'active' => 2,
            'password' => Hash::make('11111111'),
            'phone' => '45454545',
            'role_id' => role::ADMIN_ID,
        ]);
    }
}
