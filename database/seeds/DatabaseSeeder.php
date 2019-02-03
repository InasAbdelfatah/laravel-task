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
        DB::table('users')->insert([
            'first_name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456'),
            'is_admin' => 1,
        ]);
    }
}

