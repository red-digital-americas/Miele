<?php

use Illuminate\Database\Seeder;
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => env('ADMIN_USERNAME'),
            'email' => env('ADMIN_EMAIL'),
            'password' => app('hash')->make(env('ADMIN_EMAIL_PASS')),
            'remember_token' => str_random(10),
        ]);
    }
}
