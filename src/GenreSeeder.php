<?php

namespace Arsangamal\MovieSeeder;


use Arsangamal\MovieSeeder\Models\Genre;
use Arsangamal\MovieSeeder\TMDB\Seeder;

class GenreSeeder extends Seeder
{
    public function seed(array $data)
    {
        //extract genres from array
        $genres = $data['genres'];

        foreach ($genres as $genre) {

            // keys to catch genre already exists or not
            $identifiers = [
                'tmdb_id' => $genre['id'],
                'name' => strtolower($genre['name'])
            ];

            // create record if not found
            Genre::firstOrCreate($identifiers);
        }

        return true;
    }
}
