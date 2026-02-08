<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class MovieListController extends Controller
{
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'User not authenticated'], 401);
        }
    
        $user = Auth::user();
        $movieId = $request->movie_id;
    
        // Ambil data film dari TMDB API jika belum ada di database
        $movie = Movie::where('tmdb_id', $movieId)->first();
    
        if (!$movie) {
            $tmdbResponse = Http::withToken(config('services.tmdb.token'))
                ->get("https://api.themoviedb.org/3/movie/{$movieId}")
                ->json();
    
            // Pastikan data dari TMDB valid sebelum menyimpan
            if (!isset($tmdbResponse['title'])) {
                return response()->json(['success' => false, 'message' => 'Movie not found in TMDB'], 404);
            }
    
            // Simpan film ke database lokal
            $movie = Movie::create([
                'tmdb_id' => $movieId,
                'title' => $tmdbResponse['title'],
                'poster_path' => $tmdbResponse['poster_path'] ?? '',
                'release_date' => $tmdbResponse['release_date'] ?? null
            ]);
        }
    
        // Cek apakah film sudah ada di watchlist user
        if ($user->savedMovies()->where('movie_id', $movie->id)->exists()) {
            return response()->json(['success' => false, 'message' => 'Movie already in watchlist']);
        }
    
        // Tambahkan ke watchlist user
        $user->savedMovies()->attach($movie->id);
    
        return response()->json(['success' => true, 'message' => 'Movie added to watchlist']);
    }
    
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'You need to log in first.');
        }

        // Ambil daftar film yang disimpan user
        $watchlist = $user->savedMovies()->get();

        return view('profile.movielist', compact('watchlist'));
    }

    public function destroy($movieId)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'User not authenticated'], 401);
        }

        $user = Auth::user();
        
        $movie = Movie::where('tmdb_id', $movieId)->first();

        if (!$movie) {
            return response()->json(['success' => false, 'message' => 'Movie not found'], 404);
        }

        // Hapus film dari watchlist
        $user->savedMovies()->detach($movie->id);

        return response()->json(['success' => true, 'message' => 'Movie removed from watchlist']);
    }
}
