<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);


        DB::table('users')->insert([
            'name' => "Andy",
            'last_name' => "Caicedo",
            'email' => "andycr95@icloud.com",
            'password' => Hash::make("andycr19"),
            'phone' => "3128978597",
            'address' => "cr 68",
            'photo' => "avatars/PzjykoDHRh10pAYhu3gchAC6tyuc5585tsmkeXIL.jpeg",
        ]);
    }
}
