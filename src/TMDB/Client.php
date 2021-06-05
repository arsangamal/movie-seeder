<?php


namespace Arsangamal\MovieSeeder\TMDB;


use GuzzleHttp\Client as GuzzleClient;

class Client extends GuzzleClient
{
    /**
     * @var string base_uri
     */
    private $base_uri = 'https://api.themoviedb.org/3/';


    /**
     * Client constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        // merge default config with config sent
        $config = array_merge($this->defaultConfig(), $config);

        // construct the client
        parent::__construct($config);
    }


    /**
     * Get the base configuration for TMDB client
     *
     * @return string[]
     * @author Arsan Gamal <arsan.gamal@hotmail.com>
     */
    private function defaultConfig()
    {
        return [
            'base_uri' => $this->base_uri,
        ];
    }


}
