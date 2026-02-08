<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Services\TMDBService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    // public function boot()
    // {
    //     View::composer(['dashboard', 'movies.popular'], function ($view) {
    //         $tmdbService = app(TMDBService::class);
    //         $allMovies = [];
    
    //         for ($i = 1; $i <= 3; $i++) {  
    //             $movies = $tmdbService->getTopRatedMovies($i);
    //             if (isset($movies['results'])) {
    //                 $allMovies = array_merge($allMovies, $movies['results']);
    //             }
    //         }

    //         // dd($movies);

    //         // dd(count($allMovies), $allMovies);
    //         // dd($allMovies);
    //         $view->with('movies', $allMovies); // Kirim ke Blade
    //     });
    // }
    
}
