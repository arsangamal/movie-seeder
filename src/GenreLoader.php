<?php

namespace Arsangamal\MovieSeeder;

use Arsangamal\MovieSeeder\TMDB\Client;
use Arsangamal\MovieSeeder\TMDB\Loader;
use Psr\Http\Message\ResponseInterface;

class GenreLoader extends Loader
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
    public function requestGenres()
    {
        return $this->client->get('genre/movie/list');
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
    public function getGenres()
    {
        $response = $this->requestGenres();

        $jsonData = $this->extractJsonFromClient($response);

        return $this->jsonToArray($jsonData);
    }

}
