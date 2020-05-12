<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use App\Category;
use App\Tag;
use App\User;

class Post extends Model
{
	use SoftDeletes;
    protected $fillable = [
    	'title', 'description', 'content', 'published_at', 'image','category_id','user_id'
    ];

    public function deleteImage(){
    	Storage::delete($this->image);
    }

    public function category(){
    	return $this->belongsTo(Category::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }

    public function hasTag($tagId){
        return in_array($tagId, $this->tags->pluck('id')->toArray());
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function scopeSearch($query){
        
        $search = request()->query('search');

        if(!$search){
            return $query;
        }else{
            return $search = $query->where('title', 'LIKE', "%{$search}%");
        }
    }
}
