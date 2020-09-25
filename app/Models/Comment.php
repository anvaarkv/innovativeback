<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    protected $fillable = [];
    protected $guarded = [];

    public  function film(){
       return $this->belongsTo(Film::class)->withDefault();
    }
}
