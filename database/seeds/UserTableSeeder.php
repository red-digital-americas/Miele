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
            'id'                => 1,
            'idRole'             => 1,
            'name'              => env('ADMIN_USERNAME'),
            'email'             => env('ADMIN_EMAIL'),
            'password'          => app('hash')->make(env('ADMIN_EMAIL_PASS', 'admin')),
            'offline'            => env('ADMIN_EMAIL_PASS', 'admin'),
            'remember_token'    => str_random(10),
        ]);
    }
}
