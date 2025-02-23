<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'description', 'imagePath', 'user_id', 'group_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function group() {
        return $this->belongsTo(Group::class);
    }

    public function ratings() {
        return $this->hasMany(Rating::class, 'post_id');
    }

    public function avgPostRating() {
        $result = 'No ratings';

        $count = $this->ratings()
        ->count();

        if($count) {
            $sum = $this->ratings()
            ->sum('rating_value');

            $result = round($sum/$count, 1);
        }

        return $result;
    }

}
