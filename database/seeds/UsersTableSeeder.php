<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'username' => 'Ahmed.Gamal',
            'email' => 'test@test.com',
            'password' => bcrypt(123456),
        ]);
    }
}
