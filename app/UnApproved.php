<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnApproved extends Model
{
	public $timestamps = false;
	protected $table = 'story_detail';
    	protected $fillable = [
        		'slug', 'avatar', 'name', 'author','content','link','chapter',
    	];
}
