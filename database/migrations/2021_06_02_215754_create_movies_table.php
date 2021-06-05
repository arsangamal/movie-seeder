<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table = config('movie-seeder.tables.movies-table-name');

        Schema::create($table, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('tmdb_id');
            $table->boolean('adult');
            $table->string('backdrop_path')->nullable();
            $table->json('belongs_to_collection')->nullable();
            $table->integer('budget');
            $table->string('homepage')->nullable();
            $table->string('imdb_id')->nullable();
            $table->string('original_language');
            $table->string('original_title');
            $table->text('overview')->nullable();
            $table->double('popularity');
            $table->string('poster_path')->nullable();
            $table->json('production_companies');
            $table->json('production_countries');
            $table->date('release_date')->nullable();
            $table->integer('revenue');
            $table->integer('runtime')->nullable();
            $table->json('spoken_languages')->nullable();
            $table->enum('status',['Rumored', 'Planned', 'In Production', 'Post Production', 'Released', 'Canceled']);
            $table->string('tagline')->nullable();
            $table->string('title');
            $table->boolean('video');
            $table->double('vote_average');
            $table->integer('vote_count');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table = config('movie-seeder.tables.movies-table-name');

        Schema::dropIfExists($table);
    }
}
