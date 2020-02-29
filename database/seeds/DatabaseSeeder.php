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

        $user = DB::table('users')->insert([
            'name' => "Vitam",
            'last_name' => "Venture",
            'email' => "admin@vitamventure.com",
            'password' => Hash::make("vitam2020"),
            'phone' => "3128978597",
            'address' => "Nueva granada",
            'photo' => "avatars/PzjykoDHRh10pAYhu3gchAC6tyuc5585tsmkeXIL.jpeg",
        ]);

        DB::table('cities')->insert([
            'name' => "Buenaventura",
        ]);

        DB::table('cities')->insert([
            'name' => "Cali",
        ]);

        DB::table('cities')->insert([
            'name' => "Santander de Quilichao",
        ]);

        DB::table('type_sales')->insert([
            'name' => "Diario",
            'amount' => 365,
        ]);

        DB::table('type_sales')->insert([
            'name' => "Semanal",
            'amount' => 52,
        ]);

        DB::table('type_sales')->insert([
            'name' => "Quincenal",
            'amount' => 26,
        ]);

        DB::table('type_sales')->insert([
            'name' => "Mensual",
            'amount' => 12,
        ]);

        DB::table('investors')->insert([
            'user_id' => 1,
            'state' => "1",
            'type' => 1,
        ]);
    }
}
