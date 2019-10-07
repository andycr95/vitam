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

        /* DB::table('cities')->insert([
            'name' => "Buenaventura",
        ]);

        DB::table('cities')->insert([
            'name' => "Cali",
        ]);

        DB::table('cities')->insert([
            'name' => "Santander de Quilichao",
        ]); */

        /* DB::table('types')->insert([
            'counter' => 365,
            'name' => "Nueva",
        ]);

        DB::table('types')->insert([
            'counter' => 0,
            'name' => "Segunda",
        ]);

        DB::table('types')->insert([
            'counter' => 0,
            'name' => "Especial",
        ]); */

        DB::table('type_sales')->insert([
            'name' => "Diario",
        ]);

        DB::table('type_sales')->insert([
            'name' => "Semanal",
        ]);

        DB::table('type_sales')->insert([
            'name' => "Quicenal",
        ]);

        DB::table('type_sales')->insert([
            'name' => "Mensual",
        ]);

        /* DB::table('users')->insert([
            'name' => "Andy",
            'last_name' => "Caicedo",
            'email' => "andycr95@icloud.com",
            'password' => Hash::make("andycr19"),
            'phone' => "3128978597",
            'address' => "cr 68",
            'photo' => "avatars/PzjykoDHRh10pAYhu3gchAC6tyuc5585tsmkeXIL.jpeg",
        ]); */
    }
}
