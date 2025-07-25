<?php

declare(strict_types=1);

namespace App\Models;


class TMDB_API
{
    private static $genres;

    public static function setGenres(string $language = 'en')
    {
        if (isset(self::$genres)) {
            return;
        }

        $client = new \GuzzleHttp\Client();

        $response = json_decode((string) $client->request('GET', "https://api.themoviedb.org/3/genre/movie/list?language=$language", [
            'headers' => [
                'Authorization' => 'Bearer ' . $_ENV['API_KEY'],
                'accept' => 'application/json',
            ],
        ])
            ->getBody(), true);

        foreach ($response['genres'] as $genre) {
            self::$genres[$genre['id']] = $genre['name'];
        }

        // foreach (self::$genres as $key => $value) {
        //     echo self::$genres[$key]. '<br>';
        // }

        unset($client);
    }


    public static function getGenres(): array
    {
        // var_dump(self::$genres);
        return self::$genres;
    }

    public static function searchMovie(string $query, array $params = []): array
    {
        $client = new \GuzzleHttp\Client();


        $response = $client->request('GET', "https://api.themoviedb.org/3/search/movie?query=$query&include_adult=false&language=en-US&page=1", [
            'headers' => [
                'Authorization' => 'Bearer ' . $_ENV['API_KEY'],
                'accept' => 'application/json',
            ],
        ]);

        unset($client);

        return json_decode((string) $response->getBody(), true);
    }

    public static function getMovieDetails(int $id): array
    {

        $client = new \GuzzleHttp\Client();

        $uri = "https://api.themoviedb.org/3/movie/$id?append_to_response=credits,images,recommendations";

        $res = $client->request(
            'GET',
            $uri,
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $_ENV['API_KEY'],
                    'accept' => 'application/json',
                ]
            ]
        );

        $decoded_json = json_decode((string) $res->getBody(), true);
        unset($client);

        return $decoded_json;
    }


    public static function getPopular(): array
    {
        $client = new \GuzzleHttp\Client();

        $response = $client->request('GET', 'https://api.themoviedb.org/3/movie/popular?language=en-US&page=1', [
            'headers' => [
                'Authorization' => 'Bearer ' . $_ENV['API_KEY'],
                'accept' => 'application/json',
            ],
        ]);

        unset($client);

        return json_decode((string) $response->getBody(), true);
    }


}