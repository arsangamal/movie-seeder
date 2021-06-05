<?php

namespace Arsangamal\MovieSeeder\Facades;

use Illuminate\Support\Facades\Facade;

class GenreLoader extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'genre-loader';
    }
}
