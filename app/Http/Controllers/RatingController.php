<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function createRating(Request $request, Post $post) {
        $incomingFields = $request->validate([
            'rating_value' => ['required','integer','min:1', 'max:5'],
        ]);

        $incomingFields['user_id'] = auth()->user()->id;
        $incomingFields['post_id'] = $post['id'];

        if( Rating::where('user_id', $incomingFields['user_id'])->where('post_id', $incomingFields['post_id'])->exists()) {
            return redirect()->route('groups.show.single', ['group' => $post['group_id']]);
        }

        Rating::create($incomingFields);

        return redirect()->route('groups.show.single', ['group' => $post['group_id']]);        
    }

    public function displayRating(Post $post) {
        $ratings = $post->ratings()->get();

        dd($ratings);
    }

    public function avgPostRating(Post $post) {
        $result = 'No ratings';

        $count = $post->ratings()
        ->where('post_id', $post['post_id'])
        ->count();

        if($count) {
            $sum = $post->ratings()
            ->where('post_id', $post['id'])
            ->sum('rating_value');

            $result = round($sum/$count, 1);
        }

        return $result;
    }
}
