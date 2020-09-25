<?php

namespace App\Http\Controllers;

use App\Http\Resources\FilmResource;
use App\Models\DocumentTemplate;
use App\Models\Film;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
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
        return FilmResource::collection(Film::paginate(1));
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
            'country' => 'required',
            'genre' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "error" => 'validation_error',
                "message" => $validator->errors(),
            ], 422);
        }


        if($request->has('genre')){
            $genre = json_decode($request->input('genre'),true);
            $genres = array_map(function($tag) {
                return array(
                    'title' => $tag['value']
                );
            }, $genre);
        }

        $imgName = 'noimage.png';
        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $path = public_path('images/');
            $folder = File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
            $imgName = time() . '.' . $image->getClientOriginalExtension();
            $image->move($path . '/', $imgName);
        }
        $film = Film::create([
            'user_id' => 1,
            'name' => $request->name,
            'description' => $request->description,
            'release_date' => $request->release_date,
            'rating' => $request->rating,
            'ticket_price' => $request->ticket_price,
            'country_id' => $request->country,
            'photo' => $imgName
        ]);
        $film->genre()->createMany($genres);
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
        return new FilmResource(Film::FindOrFail($id));
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
        $film = Film::findOrFail($id);
        $film->delete();

        return new FilmResource($film);
    }
}
