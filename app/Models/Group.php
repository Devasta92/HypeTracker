<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['name', 'description', 'imagePath', 'user_id'];

    // Gibt alle posts aus der Post_group DB wieder, wo die Group_id passt
    public function posts() {
        return $this->hasMany(Post::class, 'group_id');
    }

    public function members() {
        return $this->belongsToMany(User::class);
    }
}
