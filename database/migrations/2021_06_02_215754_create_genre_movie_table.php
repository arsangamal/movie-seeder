<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGenreMovieTable extends Migration
{
    private $table;

    public function __construct()
    {
        //get tables
        $moviesTableName = config('movie-seeder.tables.movies-table-name');
        $genreTableName = config('movie-seeder.tables.genres-table-name');

        // wrap table names
        $tables = [$genreTableName, $moviesTableName];

        // sort them to get Laravel relationship naming convention
        sort($tables);

        // generate table name
        $this->table = implode("_", $tables);
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('movie_id');
            $table->unsignedBigInteger('genre_id');
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
        Schema::dropIfExists($this->table);
    }
}
