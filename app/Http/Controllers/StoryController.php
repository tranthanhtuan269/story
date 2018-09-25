<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Story;

class StoryController extends Controller
{
    public function slug($slug){
    	$stories = Story::where("slug", $slug)->paginate(9);
    	return view('home', ['stories' => $stories]);
    }
}
