<?php

namespace Arsangamal\MovieSeeder\Facades;

use Illuminate\Support\Facades\Facade;

class GenreSeeder extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'genre-seeder';
    }
}
