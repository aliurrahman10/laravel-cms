<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Post;

class Category extends Model
{
    use SoftDeletes;

    public function posts(){
    	return $this->hasMany(Post::class);
    }
}
