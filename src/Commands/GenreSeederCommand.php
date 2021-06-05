<?php

namespace Arsangamal\MovieSeeder\Commands;

use Arsangamal\MovieSeeder\Facades\GenreLoader;
use Arsangamal\MovieSeeder\Facades\GenreSeeder;
use Illuminate\Console\Command;

class GenreSeederCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'genre:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the genre table with the latest genres from TMDB';

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
            $this->info("Getting Genres from TMDB..");

            $genresArray = GenreLoader::getGenres();

            $this->info("Genres Fetched successfully!");

            $this->info("Starting Genres Seeding..");

            GenreSeeder::seed($genresArray);

            $this->info("Genres seeded successfully!");

            return 0;

        } catch (Exception $ex) {

            $this->error("An Error has occurred: {$ex->getMessage()}");

            return 1;
        }
    }
}
