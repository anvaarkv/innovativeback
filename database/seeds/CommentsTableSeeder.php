<?php

use App\Models\Film;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $comments = Film::with('user')->get()->map(function (Film $film) {
            return [
                'film_id' => $film->id,
                'name' => $film->user->name,
                'comment' => 'comment is here',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ];

        })->toArray();
        DB::table('comments')->insert($comments);
    }
}
