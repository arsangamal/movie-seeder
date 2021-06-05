<?php

namespace Arsangamal\MovieSeeder;

use Arsangamal\MovieSeeder\TMDB\Client;
use Arsangamal\MovieSeeder\TMDB\Loader;
use Psr\Http\Message\ResponseInterface;

class MovieLoader extends Loader
{
    /**
     * TMDB client to requests resources
     *
     * @var Client
     */
    private $client;


    /**
     * Authentication key for TMDB
     *
     * @var string api_key
     */
    private $api_key;

    /**
     * Number of movies to get from resource
     *
     * @var integer count
     */
    private $count;


    /**
     * MovieSeeder constructor.
     */
    public function __construct()
    {
        $this->initConfiguration();

        $this->initClient();
    }

    /**
     * prepare client for usage
     *
     * @author Arsan Gamal <arsan.gamal@hotmail.com>
     */
    private function initClient()
    {
        $this->client = new Client([
            'query' => [
                'api_key' => $this->api_key
            ]
        ]);
    }


    /**
     * Initiate configurations
     *
     * @author Arsan Gamal <arsan.gamal@hotmail.com>
     */
    private function initConfiguration()
    {
        $configuration = config('movie-seeder');

        $this->count = $configuration['num_of_records'] ?? 0;

        $this->api_key = $configuration['api_key'] ?? '';
    }

    /**
     * Fire a request to Genres endpoint
     *
     * @return ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @author Arsan Gamal <arsan.gamal@hotmail.com>
     */
    public function requestTopRatedMovies($page = 1)
    {

        if ($page != 1) {
            return $this->client->get("movie/top_rated?page=$page");
        }

        return $this->client->get('movie/top_rated');
    }


    /**
     * Extract body contents from Response
     *
     * @param ResponseInterface $response
     * @return string
     * @author Arsan Gamal <arsan.gamal@hotmail.com>
     */
    public function extractJsonFromClient(ResponseInterface $response)
    {
        return $response->getBody()->getContents();
    }


    /**
     * Convert JSON to Array
     *
     * @param string $jsonString
     * @return false|string
     * @author Arsan Gamal <arsan.gamal@hotmail.com>
     */
    public function jsonToArray(string $jsonString)
    {
        return json_decode($jsonString, true);
    }


    /**
     * Request genres from TMDB
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @author Arsan Gamal <arsan.gamal@hotmail.com>
     */
    public function getTopRatedMovies($page = 1)
    {
        $response = $this->requestTopRatedMovies($page);

        $jsonData = $this->extractJsonFromClient($response);

        return $this->jsonToArray($jsonData);
    }


    /**
     * Get Recent movies
     * @return false|string
     * @author Arsan Gamal <arsan.gamal@hotmail.com>
     */
    public function getRecentMovie()
    {
        $response = $this->requestRecentMovies();

        $jsonData = $this->extractJsonFromClient($response);

        return $this->jsonToArray($jsonData);
    }


    private function requestRecentMovies()
    {
        return $this->client->get('movie/latest');
    }


    public function getTopRatedMoviesIDs()
    {
        // to get exact count desired we decrement one
        // since we will get a movie from the latest movie endpoint
        $movieCount = intval(config('movie-seeder.num_of_records', 1)) - 1;

        $counter = 0;
        $page = 1;
        $movieIDsArray = [];

        do {

            $topRatedMovies = $this->getTopRatedMovies($page);
            $topRatedMovies = $topRatedMovies['results'];

            foreach ($topRatedMovies as $topRatedMovie) {

                //get all movie IDs
                $movieIDsArray[] = $topRatedMovie['id'];
                $counter++;

                if ($counter == $movieCount) {
                    break;
                }
            }

            // increment page
            // if movie counter not fulfilled
            $page++;

        } while ($counter != $movieCount);

        return $movieIDsArray;
    }


    /**
     * Get array of Movies that should be requested
     *
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @author Arsan Gamal <arsan.gamal@hotmail.com>
     */
    public function getMovies()
    {
        $moviesIDs = $this->getTopRatedAndRecentMovies();

        $movies = [];

        foreach ($moviesIDs as $id) {
            $movies[] = $this->getMovieByID($id);
        }

        return $movies;
    }

    /**
     * Get recent movie ID
     *
     * @return array|string[]
     * @author Arsan Gamal <arsan.gamal@hotmail.com>
     */
    private function getRecentMovieId()
    {
        $recentMovie = $this->getRecentMovie();
        return [$recentMovie['id']];
    }

    /**
     * Get both top rated and recent Movies ids merged
     *
     * @return array|string[]
     * @author Arsan Gamal <arsan.gamal@hotmail.com>
     */
    public function getTopRatedAndRecentMovies(): array
    {
        return array_merge($this->getTopRatedMoviesIDs(), $this->getRecentMovieId());
    }


    /**
     * Get a specific movie by its id
     *
     * @param $id
     * @return false|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @author Arsan Gamal <arsan.gamal@hotmail.com>
     */
    public function getMovieByID($id)
    {
        $movie = $this->client->get("movie/{$id}");

        $jsonData = $this->extractJsonFromClient($movie);

        return $this->jsonToArray($jsonData);

    }

}
