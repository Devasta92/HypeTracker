<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post_group extends Model
{
    public $timestamps = false;
    protected $fillable = ['post_id', 'group_id'];
}
