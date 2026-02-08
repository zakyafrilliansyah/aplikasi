<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MovieListController;
use App\Http\Controllers\DiscussionController;


Route::get('/', [MovieController::class, 'home'])->name('home');

Route::get('/dashboard', [MovieController::class, 'home'])->name('dashboard');
Route::get('/popular', [MovieController::class, 'showGenreMovies'])->name('popular');
Route::get('/movies/popular', [MovieController::class, 'index'])->name('movies.popular');
Route::get('/popular/filter', [FilterController::class, 'filterMovies'])->name('movies.filter');
Route::get('/movies/search', [SearchController::class, 'search'])->name('movies.search');
Route::get('/movies/{movieid}', [MovieController::class, 'showMovieDetails'])->name('movies.detail');

// 📝 Review System: hanya user yang login bisa memberi review
Route::middleware('auth')->group(function () {
    Route::post('/movies/{movieid}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy'])->name('reviews.destroy'); 
});

Route::middleware('auth')->group(function () {
    Route::post('/discussion/store', [DiscussionController::class, 'store'])->name('discussion.store');
    
});

Route::get('/discussion/fetch', [DiscussionController::class, 'fetch'])->name('discussion.fetch');

// 🔍 Rute untuk menampilkan daftar review suatu film (bisa diakses oleh semua orang)
Route::get('/movies/{movieid}/reviews', [ReviewController::class, 'showReviews'])->name('reviews.index');

Route::get('/people', [PeopleController::class, 'index'])->name('people');
Route::get('/people/{personId}', [PeopleController::class, 'showPersonDetails'])->name('people.details');

Route::get('/movies/{movieid}/reviews', [ReviewController::class, 'index'])->name('reviews.index');



Route::middleware('auth')->group(function () {
    Route::get('/movies/saved', [MovieListController::class, 'index'])->name('watchlist.index');
    Route::post('/movies/save', [MovieListController::class, 'store'])->name('watchlist.store');
    Route::delete('/movies/remove/{id}', [MovieListController::class, 'destroy'])->name('watchlist.destroy');
});


// 🔒 Profile Management: hanya user login yang bisa edit, update, atau hapus profil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
