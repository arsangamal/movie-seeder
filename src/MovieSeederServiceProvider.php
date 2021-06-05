<?php

namespace Arsangamal\MovieSeeder;

use Arsangamal\MovieSeeder\Commands\GenreSeederCommand;
use Arsangamal\MovieSeeder\Commands\MovieSeederCommand;
use Illuminate\Support\ServiceProvider;

class MovieSeederServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'arsangamal');
         //$this->loadViewsFrom(__DIR__.'/../resources/views', 'arsangamal');
         $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
         $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/movie-seeder.php', 'movie-seeder');

        // Register the genre seeder service.
        $this->app->bind('genre-seeder', function ($app) {
            return new GenreSeeder();
        });

        // Register the genre loader service
        $this->app->bind('genre-loader', function($app){
            return new GenreLoader();
        });

        // Register the movie seeder service.
        $this->app->bind('movie-seeder', function ($app) {
            return new MovieSeeder;
        });

        // Register the movie loader service
        $this->app->bind('movie-loader', function($app){
            return new MovieLoader();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'genre-seeder',
            'genre-loader',
            'movie-seeder',
            'movie-loader',
        ];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/movie-seeder.php' => config_path('movie-seeder.php'),
        ], 'movie-seeder.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/arsangamal'),
        ], 'movie-seeder.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/arsangamal'),
        ], 'movie-seeder.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/arsangamal'),
        ], 'movie-seeder.views');*/

        // Registering package commands.
         $this->commands([
             GenreSeederCommand::class,
             MovieSeederCommand::class,
         ]);
    }
}
