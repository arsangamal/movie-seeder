<?php

namespace Arsangamal\MovieSeeder\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $table = "genres";
    protected $fillable = [
        'tmdb_id',
        'name'
    ];
}
