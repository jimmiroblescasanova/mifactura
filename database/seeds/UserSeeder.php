<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'      => 'Jimmi Robles',
            'rfc'       => 'ROCJ9002272X8',
            'email'     => 'jimmirobles@icloud.com',
            'password'  => Hash::make('password'),
            'is_admin'  => 1,
        ]);
    }
}
