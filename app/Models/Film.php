<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{

    public $table = 'films';
    protected $fillable = [];
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class,'film_id','id');
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }
    public function genre(){
        return $this->hasMany(Genre::class,'film_id','id');
    }
}
