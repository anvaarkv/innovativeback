<?php

namespace App\Http\Controllers;

use App\Http\Resources\FilmResource;
use App\Models\Film;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return FilmResource::collection(Film::paginate(25));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'required',
            'description' => 'required',
            'release_date' => 'required|date',
            'rating' => 'required|integer|between:1,5',
            'ticket_price' => 'required',
            'photo' => 'required',
            'country_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "error" => 'validation_error',
                "message" => $validator->errors(),
            ], 422);
        }

        $film = Film::create([
            'user_id' => 1,
            'name' => $request->name,
            'description' => $request->description,
            'release_date' => $request->release_date,
            'rating' => $request->rating,
            'ticket_price' => $request->ticket_price,
            'country_id' => $request->country_id,
            'photo' => 'noimage.png'
        ]);
        if ($film && $request->has('genre')) {
            $genre = explode(',', $request->genre);
            for ($i = 0; $i < count($genre); $i++) {
                $genres = Genre::create([
                    'film_id' => $film->id,
                    'title' => $genre[$i],
                ]);
            }
        }

        return new FilmResource($film);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
