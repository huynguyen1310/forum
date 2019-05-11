<?php

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
        DB::table('users')->insert([
            'name' => 'HuyNguyen',
            'email' => 'qhuy131096@gmail.com',
            'password' => bcrypt('123456789'),
            'confirmed' => true
        ]);
    }
}
