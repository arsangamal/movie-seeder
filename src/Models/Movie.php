<?php

namespace Arsangamal\MovieSeeder\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $table = "movies";
    protected $guarded = [];
    private $relationshipTable;

    /**
     * Movie constructor to set table name for instantiation.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $table = config('movie-seeder.tables.movies-table-name');
        $this->table = $table;

        //get tables
        $moviesTableName = config('movie-seeder.tables.movies-table-name');
        $genreTableName = config('movie-seeder.tables.genres-table-name');

        // wrap table names
        $tables = [$genreTableName, $moviesTableName];

        // sort them to get Laravel relationship naming convention
        sort($tables);

        // generate table name
        $this->relationshipTable = implode("_", $tables);
    }

    /**
     * override newInstance method to set table for static calls
     *
     * @param array $attributes
     * @param false $exists
     * @return Movie
     * @author Arsan Gamal <arsan.gamal@hotmail.com>
     */
    public function newInstance($attributes = [], $exists = false)
    {
        $model = parent::newInstance($attributes, $exists); // TODO: Change the autogenerated stub
        $table = config('movie-seeder.tables.movies-table-name');
        $model->setTable($table);
        return $model;
    }

    /**
     * Get related genres
     *
     * @author Arsan Gamal <arsan.gamal@hotmail.com>
     */
    public function genres()
    {
        return $this->belongsToMany(Genre::class, $this->relationshipTable, 'movie_id', 'genre_id');
    }
}
