<?php

namespace Arsangamal\MovieSeeder\Commands;

use Arsangamal\MovieSeeder\Facades\MovieLoader;
use Arsangamal\MovieSeeder\Facades\MovieSeeder;
use Arsangamal\MovieSeeder\Models\Genre;
use Illuminate\Console\Command;

class MovieSeederCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'movie:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the movies table with the latest movies from TMDB';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {

            // ensure Genres seeding is ran
            if (Genre::count() == 0) {

                $this->error("No Genres found");
                $choice = $this->confirm("run genres seeding ?", false);

                if ($choice) {
                    $this->call('genre:seed');
                } else {
                    $this->info("Please run artisan genre:seed command before seeding movies");
                    return 0;
                }

            }

            $this->info("Getting Movies from TMDB..");

            $moviesArray = MovieLoader::getMovies();

            $this->info("Movies Fetched Successfully!");

            $this->info("Starting Movies Seeding..");

            MovieSeeder::seed($moviesArray);

            $this->info("Movies seeded successfully!");

            return 0;

        } catch (Exception $ex) {

            $this->error("An Error has occurred: {$ex->getMessage()}");

            return 1;
        }
    }
}
