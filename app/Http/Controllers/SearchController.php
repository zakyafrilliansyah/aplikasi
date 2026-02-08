<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TMDbService;

class SearchController extends Controller
{
    protected $tmdbService;

    public function __construct(TMDbService $tmdbService)
    {
        $this->tmdbService = $tmdbService;
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $page = $request->input('page', 1); // Pastikan pagination tetap berjalan
        $certificationCountry = $request->input('certification_country');
        $certification = $request->input('certification');
        $includeAdult = $request->input('include_adult', false);
    
        if (!$query) {
            return redirect()->route('home')->with('error', 'Please enter a search query.');
        }
    
        $movies = $this->tmdbService->searchMovies($query, $page, $certificationCountry, $certification, $includeAdult);
    
        if (isset($movies['error'])) {
            return view('movies.error', ['message' => $movies['error']]);
        }
    
        return view('movies.search', compact('movies', 'query'));
    }
    
    
}
