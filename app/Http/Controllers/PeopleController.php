<?php
namespace App\Http\Controllers;

use App\Services\PeopleService;
use Illuminate\Http\Request;
use App\Services\TMDbService;

class PeopleController extends Controller
{
    protected $peopleService;

    public function __construct(PeopleService $peopleService)
    {
        $this->peopleService = $peopleService;
    }

    public function index(Request $request)
    {
        $page = $request->input('page', 1); // Halaman default 1

        // Ambil daftar aktor populer dari TMDb API
        $people = $this->peopleService->getPopularPeople($page);

        // Tampilkan ke view
        return view('people.index', compact('people'));
    }

    public function showPersonDetails($personId)
    {
        // Ambil data orang berdasarkan ID
        $person = $this->peopleService->getPersonDetails($personId);
    
        // Jika data tidak ditemukan, beri respon 404
        if (!$person || isset($person['error'])) {
            abort(404, $person['error'] ?? 'Person not found.');
        }
        
        // dd($person);
        // Passing data ke view
        return view('people.detail', compact('person'));
    }


    public function showPersonMovies($personId)
    {
        $movies = $this->peopleService->getPersonMovies($personId);

        if (!$movies) {
            abort(404, 'Movies not found for this person.');
        }

        return view('people.movies', compact('movies'));
    }

    
}
