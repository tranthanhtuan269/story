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
        $stories = DB::table('story_detail')->select('slug', 'avatar', 'name', 'author')->groupBy('slug', 'avatar', 'name', 'author')->paginate(9);
        return view('home', ['stories' => $stories]);
    }

    public function slug(){
        $stories = UnApproved::get();
        foreach ($stories as $story) {
            $story->slug = str_slug($story->name);
            $story->save();
        }
    }

    public function uploadImage(Request $request){
        $img_file = '';
        if (isset($request->base64)) {
            $data = $request->base64;

            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);
            $filename = time() . '.png';
            file_put_contents(base_path('public/images/stories/') . $filename, $data);

            return \Response::json(array('code' => '200', 'message' => 'success', 'image_url' => $filename));
        }
        return \Response::json(array('code' => '404', 'message' => 'unsuccess', 'image_url' => ""));
    }
}
