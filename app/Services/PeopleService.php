<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PeopleService
{
    protected $apiKey;
    protected $accessToken;

    public function __construct()
    {
        $this->accessToken = env('TMDB_ACCESS_TOKEN'); 
    }

    public function getPersonDetails($personId)
    {
        $response = Http::withToken($this->accessToken)
            ->get("https://api.themoviedb.org/3/person/{$personId}", [
                'language' => 'en-US',
                'append_to_response' => 'movie_credits',
            ]);

        if ($response->successful()) {
            return $response->json();
        }

        return [
            'error' => 'Failed to fetch person details. Status code: ' . $response->status(),
        ];
    }

    public function getPersonMovies($personId)
    {
        $response = Http::withToken($this->accessToken)
            ->get("https://api.themoviedb.org/3/person/{$personId}/movie_credits", [
                'language' => 'en-US',
            ]);

        if ($response->successful()) {
            return $response->json();
        }

        return [
            'error' => 'Failed to fetch person movie credits. Status code: ' . $response->status(),
        ];
    }

    public function getPopularPeople($page = 1)
    {
        $response = Http::withToken($this->accessToken)
            ->get("https://api.themoviedb.org/3/person/popular", [
                'api_key' => $this->apiKey,
                'language' => 'en-US',
                'page' => $page,
            ]);

        if ($response->successful()) {
            return $response->json();
        }

        return [
            'error' => 'Failed to fetch popular people. Status code: ' . $response->status(),
        ];
    }

    public function getPeopleByMovieId($movieId)
    {
        $response = Http::get("https://api.themoviedb.org/3/movie/{$movieId}/credits", [
            'api_key' => env('TMDB_API_KEY'),
            'language' => 'en-US',
        ]);
    
        if ($response->successful()) {
            return $response->json();
        }
    
        return [
            'error' => 'Failed to fetch cast from TMDb API. Status code: ' . $response->status(),
        ];
    }



}
