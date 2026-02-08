<?php
namespace App\Http\Controllers;
use App\Models\Movie;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;


class ReviewController extends Controller
{
    public function index($movieId)
    {
        $reviews = Review::where('movie_id', $movieId)->with('user')->get();
        
        return response()->json($reviews);
        
    }


    public function store(Request $request, $movieId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:10',
            'review' => 'required|string',
        ]);

        // Cek apakah film sudah ada di database
        $movie = Movie::where('tmdb_id', $movieId)->first();

        if (!$movie) {
            // Ambil data film dari API TMDB
            $apiKey = env('TMDB_API_KEY'); // Pastikan API key ada di .env
            $response = Http::get("https://api.themoviedb.org/3/movie/$movieId", [
                'api_key' => $apiKey,
                'language' => 'en-US'
            ]);

            if ($response->successful()) {
                $data = $response->json();

                // Simpan film ke database
                $movie = Movie::create([
                    'tmdb_id' => $data['id'],
                    'title' => $data['title'],
                    'overview' => $data['overview'],
                    'poster_path' => $data['poster_path'],
                    'vote_average' => $data['vote_average'],
                    'vote_count' => $data['vote_count'],
                ]);
            } else {
                return response()->json(['success' => false, 'message' => 'Failed to fetch movie data'], 500);
            }
        }

        // Simpan review ke database
        $review = Review::create([
            'user_id' => Auth::id(),
            'movie_id' => $movie->tmdb_id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Review added successfully!',
            'review' => $review->load('user', 'movie'),
        ]);
    }

    public function destroy($reviewId)
    {
        $review = Review::findOrFail($reviewId);

        // Cek apakah user yang login adalah pemilik review
        if (!Auth::check() || Auth::user()->id !== $review->user_id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        

        $review->delete();

        return response()->json(['success' => true]);
    }

}

