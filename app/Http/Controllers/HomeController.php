<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function films()
    {
        return view('films.index');
    }

    public function create()
    {
        return view('films.create');
    }

    public function single()
    {
        return view('films.single');
    }

    public function countries(){
        return Country::all()->toJson();//->pluck('name','id')->toJson();
    }
}
