<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TMDbService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('TMDB_API_KEY'); 
    }

    public function getPopularMovies($page = 1)
    {
        $response = Http::get("https://api.themoviedb.org/3/movie/popular", [
            'api_key' => $this->apiKey,
            'language' => 'en-US',
            'page' => $page,
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        return [
            'error' => 'Failed to fetch popular movies from TMDb API. Status code: ' . $response->status(),
        ];
    }
    
    
    public function getTopRatedMovies($page = 1)
    {
        $response = Http::get("https://api.themoviedb.org/3/movie/top_rated", [
            'api_key' => $this->apiKey,
            'language' => 'en-US',
            'page' => $page,  
        ]);
    
        if ($response->successful()) {
            $data = $response->json();
            return [
                'page' => $data['page'] ?? 1,
                'results' => $data['results'] ?? [], 
                'total_pages' => $data['total_pages'] ?? 0,
                'total_results' => $data['total_results'] ?? 0
            ];
        }
    
        return [
            'page' => 1,
            'results' => [], 
            'total_pages' => 0,
            'total_results' => 0
        ];
    }
    

    public function searchMovies($query, $page = 1, $certificationCountry = null, $certification = null, $includeAdult = false)
    {
        $params = [
            'api_key' => $this->apiKey,
            'query' => $query,
            'language' => 'en-US',
            'page' => $page,
            'include_adult' => false,
        ];

        if ($certificationCountry) {
            $params['certification_country'] = $certificationCountry;
        }

        if ($certification) {
            $params['certification'] = $certification;
        }

        $response = Http::get("https://api.themoviedb.org/3/search/movie", $params);

        if ($response->successful()) {
            return $response->json();
        }

        return [
            'error' => 'Failed to search movies from TMDb API. Status code: ' . $response->status(),
        ];
    }

    public function getFilteredMovies($page = 1, $sortBy = 'popularity.desc', $certificationCountry = null, $certification = null, $includeAdult = false)
    {
        $params = [
            'api_key' => $this->apiKey,
            'language' => 'en-US',
            'page' => $page,
            'sort_by' => $sortBy,
            'include_adult' => $includeAdult ? 'true' : 'false',
        ];
    
        if ($certificationCountry) {
            $params['certification_country'] = $certificationCountry;
        }
    
        if ($certification) {
            $params['certification'] = $certification;
        }
    
        $response = Http::get("https://api.themoviedb.org/3/discover/movie", $params);
    
        if ($response->successful()) {
            return $response->json();
        }
    
        return [
            'error' => 'Failed to fetch filtered movies from TMDb API. Status code: ' . $response->status(),
        ];
    }


    public function getMoviesByGenre($genreId, $limit = 10)
    {
        $response = Http::get("https://api.themoviedb.org/3/discover/movie", [
            'api_key' => $this->apiKey,
            'language' => 'en-US',
            'with_genres' => $genreId,
            'page' => 1,
        ]);
    
        if ($response->successful()) {
            return array_slice($response->json()['results'], 0, $limit);
        }
    
        return [];
    }

    public function getTrendingMovies($page = 1)
    {
        $response = Http::get("https://api.themoviedb.org/3/trending/movie/day", [
            'api_key' => $this->apiKey,
            'language' => 'en-US',
            'page' => $page,
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        return [
            'error' => 'Failed to fetch trending movies from TMDb API. Status code: ' . $response->status(),
        ];
    }
    
    public function getMovieDetails($movieId)
    {
        $response = Http::get("https://api.themoviedb.org/3/movie/{$movieId}", [
            'api_key' => $this->apiKey,
            'language' => 'en-US',
            'append_to_response' => 'credits,videos,images',
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        return [
            'error' => 'Failed to fetch movie details from TMDb API. Status code: ' . $response->status(),
        ];
    }

    public function getMovieTrailer($movieId)
    {
        $response = Http::get("https://api.themoviedb.org/3/movie/{$movieId}/videos", [
            'api_key' => $this->apiKey,
            'language' => 'en-US',
        ]);
    
        if ($response->successful()) {
            $videos = $response->json()['results'];
    
            // Cari trailer pertama dari YouTube
            foreach ($videos as $video) {
                if ($video['type'] === 'Trailer' && $video['site'] === 'YouTube') {
                    return $video['key']; // Kembalikan YouTube Video ID
                }
            }
        }
    
        return null; 
    }
    

}
