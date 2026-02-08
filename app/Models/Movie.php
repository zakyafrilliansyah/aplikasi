<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'tmdb_id',
        'title',
        'overview',
        'poster_path',
        'vote_average',
        'vote_count',
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function usersWhoSaved(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'movie_user_list')->withTimestamps();
    }

}
