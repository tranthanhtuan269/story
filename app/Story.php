<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    	protected $fillable = [
        		'slug', 'name', 'author_id','category_id','views','likes',
    	];
}
