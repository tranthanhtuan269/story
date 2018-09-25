<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UnApproved;
use App\Category;
use App\Chapter;
use App\Author;
use App\Story;
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
		$categories = Category::pluck('name', 'id');
		return view('unapproved/edit', ['story' => $story, 'categories' => $categories]);
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
		$time_created = date('Y-m-d H:i:s');
		$author = Author::where('name', $request->author)->first();
		if(!isset($author)){
			// create author
			$author = new Author;
			$author->slug = str_slug($request->author);
			$author->name = $request->author;
			$author->save();
		}

		$unApproved = UnApproved::find($request->id);
		if($unApproved){
			// create story
			$story = new Story;
			$story->slug = str_slug($request->name);
			$story->name = $request->name;
			$story->avatar = $request->avatar;
			$story->author_id = $author->id;
			$story->category_id = $request->category;
			$story->views = 0;
			$story->likes = 0;
			$story->created_at = $time_created;
			$story->updated_at = $time_created;
			if($story->save()){
				$listUnApproved = UnApproved::where('slug', $unApproved->slug)->get();
				foreach($listUnApproved as $unApproved){
					$chapter = new Chapter;
					$chapter->slug = $unApproved->name . ' ' . $unApproved->chapter;
					$chapter->name = $unApproved->name . ' ' . $unApproved->chapter;
					$chapter->content = $unApproved->content;
					$chapter->story_id = $story->id;
					$chapter->views = 0;
					$chapter->likes = 0;
					$chapter->created_at = $time_created;
					$chapter->updated_at = $time_created;
					if($chapter->save()){
						$unApproved->delete();
					}
				}
			}

			return response()->json([
			                'status_code' => 201
			            ], 201);    
		}
		return response()->json([
			                'status_code' => 204
			            ], 200);   
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
