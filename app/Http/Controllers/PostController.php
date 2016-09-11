<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class PostController extends Controller
{
	// public function __construct()
	// {
	// 	$this->middleware('auth');
	// }

	public function getDashboard()
	{
		$posts = Post::orderBy('id','desc')->get();
		return view('dashboard')->withPosts($posts);
	}

	public function postCreatePost(Request $request)
	{
		$this->validate($request,[
			'body'=>'required|max:1000:min:3'
			]);

		$post = new Post;
		$post->body = $request->body;
		$request->user()->posts()->save($post);

		Session::flash('success','Post success');

		return redirect()->route('dashboard');
	}

	public function destroy($id)
	{
		$post = Post::find($id)->first();

		if(Auth::user() != $post->user) {
			return redirect()->back();
		}

		$post->delete();
		// Post::destroy($id);

		Session::flash('success','Successfully deleted');
		return redirect()->route('dashboard');
	}
}


