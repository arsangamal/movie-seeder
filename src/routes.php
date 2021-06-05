<?php


use Illuminate\Support\Facades\Route;
use Arsangamal\MovieSeeder\Http\Controllers\MoviesController;

Route::get('/movies', [MoviesController::class, 'listing']);
