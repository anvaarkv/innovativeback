<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    public $table = 'genres';
    protected $fillable = [];
    protected $guarded = [];

    public function film(){
        return $this->belongsTo(Film::class);
    }
}
