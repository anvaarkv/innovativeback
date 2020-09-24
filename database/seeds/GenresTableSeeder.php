<?php

use App\Models\Film;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $genre = Film::all()->map(function (Film $film) {
            return [
                'film_id' => $film->id,
                'title' => 'Thriller',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ];

        })->toArray();
        DB::table('genres')->insert($genre);
    }
}
