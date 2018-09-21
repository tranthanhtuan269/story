<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UnApproved;
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
		$stories = DB::table('story_detail')->select('id', 'avatar', 'name', 'author', 'chapter')->where('slug', $slug)->paginate(9);
		return view('unapproved/slug', ['stories' => $stories]);
	}

	public function store(Request $request){
		$unApproved = UnApproved::find($request->id);
		$unApproved->content = $request->content;
		$unApproved->save();
	}

	public function edit($id){
		$story = DB::table('story_detail')->select('id', 'name', 'avatar', 'author', 'chapter', 'link')->where('id', $id)->first();
		return view('unapproved/edit', ['story' => $story]);
	}

	public function update(Request $request, $id){
		$unApproved = UnApproved::find($request->id);
		$unApproved->chapter = $request->chapter;
		$unApproved->save();

		DB::table('story_detail')
			->where('slug', '=', $unApproved->slug)
			->update(
				array(
					'avatar' => $request->avatar,
					'name' => $request->name,
					'author' => $request->author,
					'link' => $request->link
					)
				);
		return back();
	}

	public function approve(Request $request, $id){
		$unApproved = UnApproved::find($request->id);
		$unApproved->chapter = $request->chapter;
		$unApproved->save();

		DB::table('story_detail')
			->where('slug', '=', $unApproved->slug)
			->update(
				array(
					'avatar' => $request->avatar,
					'name' => $request->name,
					'author' => $request->author,
					'link' => $request->link
					)
				);
		return back();
	}

	public function show($id){
		$story = DB::table('story_detail')->select('id', 'name', 'author', 'chapter', 'content', 'link')->where('id', $id)->first();
		return view('unapproved/show', ['story' => $story]);
	}

	public function destroy($slug){
		DB::table('story_detail')->where('slug', $slug)->delete();
		return back();
	}
}
