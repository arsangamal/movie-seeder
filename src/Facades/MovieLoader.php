<?php

namespace Arsangamal\MovieSeeder\Facades;

use Illuminate\Support\Facades\Facade;

class MovieLoader extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'movie-loader';
    }
}
