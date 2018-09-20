<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class UnapprovedController extends Controller
{
	/**
	     * Create a new controller instance.
	     *
	     * @return void
	     */
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function slug($slug){
		$stories = DB::table('story_detail')->select('id', 'name', 'author', 'chapter')->where('slug', $slug)->paginate(15);
		return view('unapproved/slug', ['stories' => $stories]);
	}

	public function show($id){
		$story = DB::table('story_detail')->select('id', 'name', 'author', 'chapter', 'content', 'link')->where('id', $id)->first();
		return view('unapproved/show', ['story' => $story]);
	}
}
