<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';
    protected $fillable = [];
    protected $guarded = [];

    public  function film(){
        $this->hasMany(Film::class,'country_id','id');
    }
}
