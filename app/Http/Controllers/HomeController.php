<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UnApproved;
use DB;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stories = DB::table('story_detail')->select('slug', 'name', 'author')->distinct()->paginate(15);
        return view('home', ['stories' => $stories]);
    }

    public function slug(){
        $stories = UnApproved::get();
        foreach ($stories as $story) {
            $story->slug = str_slug($story->name);
            $story->save();
        }
    }
}
