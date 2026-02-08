<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discussion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class DiscussionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('store'); 
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request->validate([
            'comment' => 'required|string|max:500',
            'anonymous' => 'boolean', // Pastikan anonymous berupa boolean
        ]);

        // Tentukan apakah user ingin anonim atau tidak
        $isAnonymous = $request->anonymous ?? false;
        $username = $isAnonymous ? 'Anonymous' : Auth::user()->name;

        $discussion = Discussion::create([
            'user_id' => Auth::id(),
            'comment' => $request->comment,
            'anonymous' => $isAnonymous, // Simpan status anonymous di database
        ]);

        return response()->json([
            'success' => true,
            'discussion' => [
                'id' => $discussion->id,
                'user' => $username,
                'comment' => $discussion->comment,
                'created_at' => $discussion->created_at->diffForHumans(),
            ]
        ]);
    }

    public function fetch()
    {
        $comments = Discussion::with('user')->latest()->get();

        return response()->json($comments->map(function ($comment) {
            return [
                'id' => $comment->id,
                'user' => $comment->anonymous ? 'Anonymous' : ($comment->user->name ?? 'Unknown'),
                'comment' => $comment->comment,
                'created_at' => $comment->created_at->diffForHumans(),
            ];
        }));
    }
}
