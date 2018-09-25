<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    	public $timestamps = false;
    	protected $fillable = [
        		'slug', 'name', 'content', 'story_id', 'views', 'likes', 
    	];
}
