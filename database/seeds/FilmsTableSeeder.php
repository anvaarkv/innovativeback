<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FilmsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $films = array(
            array(
                'user_id' => 1,
                'name' => 'Inception',
                'description' => '',
                'release_date' => Carbon::today(),
                'rating' => 3,
                'ticket_price' => 200,
                'country_id' => 166,
                'photo' => 'noimage.png',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'user_id' => 1,
                'name' => 'Titanic',
                'description' => '',
                'release_date' => Carbon::today(),
                'rating' => 4,
                'ticket_price' => 200,
                'country_id' => 164,
                'photo' => 'noimage.png',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'user_id' => 1,
                'name' => 'Avengers',
                'description' => '',
                'release_date' => Carbon::today(),
                'rating' => 5,
                'ticket_price' => 200,
                'country_id' => 168,
                'photo' => 'noimage.png',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            )
        );
        DB::table('films')->insert($films);
    }
}
