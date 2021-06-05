<?php

namespace Arsangamal\MovieSeeder;


use Arsangamal\MovieSeeder\Models\Movie;
use Arsangamal\MovieSeeder\TMDB\Seeder;
use Carbon\Carbon;

class MovieSeeder extends Seeder
{
    public function seed(array $data)
    {
        try {
            foreach ($data as $movie) {

                $found = Movie::where('tmdb_id', $movie['id'])->exists();
                if ($found) {
                    continue;
                }
                $releaseDate = null;

                try {
                    $releaseDate = Carbon::createFromFormat('Y-m-d', $movie['release_date']);
                }catch(\Exception $ex){
                    // nothing needed thanks
                    $releaseDate = null;
                }

                $movieModel = new Movie();
                $movieModel->tmdb_id = $movie['id'];
                $movieModel->adult = $movie['adult'];
                $movieModel->backdrop_path = $movie['backdrop_path'];
                $movieModel->belongs_to_collection = json_encode($movie['belongs_to_collection']);
                $movieModel->budget = $movie['budget'];
                $movieModel->homepage = $movie['homepage'];
                $movieModel->imdb_id = $movie['imdb_id'];
                $movieModel->original_language = $movie['original_language'];
                $movieModel->original_title = $movie['original_title'];
                $movieModel->overview = $movie['overview'];
                $movieModel->popularity = $movie['popularity'];
                $movieModel->poster_path = $movie['poster_path'];
                $movieModel->production_companies = json_encode($movie['production_companies']);
                $movieModel->production_countries = json_encode($movie['production_countries']);
                $movieModel->release_date = $releaseDate;
                $movieModel->revenue = $movie['revenue'];
                $movieModel->runtime = $movie['runtime'];
                $movieModel->spoken_languages = json_encode($movie['spoken_languages']);
                $movieModel->status = $movie['status'];
                $movieModel->tagline = $movie['tagline'];
                $movieModel->title = $movie['title'];
                $movieModel->video = $movie['video'];
                $movieModel->vote_average = $movie['vote_average'];
                $movieModel->vote_count = $movie['vote_count'];

                $movieModel->save();
                $genreIDs = [];

                foreach($movie['genres'] as $genre){
                    $genreIDs[] = $genre['id'];
                }

                $movieModel->genres()->sync($genreIDs);
            }
        }catch (Exception $ex){
            dd($ex->getMessage(), $ex->getLine());
        }

    }

}
