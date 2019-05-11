<?php

use Illuminate\Database\Seeder;

class ChannelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('channels')->insert([
            [
                'name' => 'Laravel',
                'slug' => 'laravel',
            ],
            [
                'name' => 'PHP',
                'slug' => 'php',
            ],

        ]);
    }
}
