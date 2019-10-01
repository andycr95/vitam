<?php

use Illuminate\Database\Seeder;

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

        DB::table('cities')->insert([
            'name' => "Buenaventura",
        ]);

        DB::table('cities')->insert([
            'name' => "Cali",
        ]);

        DB::table('cities')->insert([
            'name' => "Santander de Quilichao",
        ]);
    }
}
