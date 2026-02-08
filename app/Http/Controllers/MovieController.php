<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TMDbService;
use App\Services\PeopleService;
use App\Http\Controllers\ReviewController;

class MovieController extends Controller
{
    protected $tmdbService;
    protected $peopleService;

    public function __construct(TMDbService $tmdbService, PeopleService $peopleService)
    {
        $this->tmdbService = $tmdbService;
        $this->peopleService = $peopleService; 
    }

    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $movies = $this->tmdbService->getTopRatedMovies($page);
    
        // Tambahkan genre movies agar tidak error
        $genres = [
            'Action' => 28, 'Adventure' => 12, 'Animation' => 16, 'Comedy' => 35,
            'Crime' => 80, 'Documentary' => 99, 'Drama' => 18, 'Family' => 10751,
            'Fantasy' => 14, 'History' => 36, 'Horror' => 27, 'Music' => 10402,
            'Mystery' => 9648, 'Romance' => 10749, 'Science Fiction' => 878,
            'TV Movie' => 10770, 'Thriller' => 53, 'War' => 10752, 'Western' => 37
        ];
    
        $moviesByGenre = [];
        foreach ($genres as $genreName => $genreId) {
            $moviesByGenre[$genreName] = $this->tmdbService->getMoviesByGenre($genreId, 10);
        }
    
        $trendingMovies = $this->tmdbService->getTrendingMovies($page)['results'] ?? [];
        $mustWatchMovies = $this->tmdbService->getTopRatedMovies($page)['results'] ?? [];
        $allMoviesResponse = $this->tmdbService->getPopularMovies($page);
        $allMovies = $allMoviesResponse['results'] ?? [];
    
        return view('movies.popular', compact('movies', 'moviesByGenre', 'trendingMovies', 'mustWatchMovies', 'allMovies', 'allMoviesResponse'));
    }
    
    public function home(Request $request)
    {
        $page = $request->query('page', 1);

        // Mengambil data film populer dari TMDB
        $moviesResponse = $this->tmdbService->getPopularMovies($page);
        $movies = $moviesResponse ?? ['results' => []]; 

        return view('dashboard', compact('movies'));
    }



    public function showGenreMovies(Request $request)
    {
        $page = $request->input('page', 1); 
        $genres = [
            'Action' => 28, 'Adventure' => 12, 'Animation' => 16, 'Comedy' => 35,
            'Crime' => 80, 'Documentary' => 99, 'Drama' => 18, 'Family' => 10751,
            'Fantasy' => 14, 'History' => 36, 'Horror' => 27, 'Music' => 10402,
            'Mystery' => 9648, 'Romance' => 10749, 'Science Fiction' => 878,
            'TV Movie' => 10770, 'Thriller' => 53, 'War' => 10752, 'Western' => 37
        ];
    
        $moviesByGenre = [];
    
        foreach ($genres as $genreName => $genreId) {
            $moviesByGenre[$genreName] = $this->tmdbService->getMoviesByGenre($genreId, 10);
        }
        
        $trendingMovies = $this->tmdbService->getTrendingMovies($page)['results'] ?? [];
        
        $mustWatchMovies = $this->tmdbService->getTopRatedMovies($page)['results'] ?? [];

        $allMoviesResponse = $this->tmdbService->getPopularMovies($page);
        $allMovies = $allMoviesResponse['results'] ?? [];

        return view('movies.popular', compact('moviesByGenre', 'trendingMovies', 'mustWatchMovies', 'allMovies', 'allMoviesResponse'));
    }

    
    public function showMovieDetails($movieId)
    {
        // Mendapatkan detail film
        $movie = $this->tmdbService->getMovieDetails($movieId);
    
        // Jika gagal mendapatkan data film
        if (isset($movie['error'])) {
            return view('movies.error', ['message' => $movie['error']]);
        }
    
        // Mendapatkan cast film menggunakan PeopleService
        $cast = $this->peopleService->getPeopleByMovieId($movieId)['cast'] ?? [];
    
        // Mendapatkan trailer dari TMDbService
        $trailerKey = $this->tmdbService->getMovieTrailer($movieId);
    
        // Passing data ke view
        return view('movies.details', compact('movie', 'cast', 'trailerKey'));
    }
    

}

