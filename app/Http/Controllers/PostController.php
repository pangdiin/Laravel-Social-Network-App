<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use App\Like;
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

	public function postEditPost(Request $request)
	{
		$this->validate($request, [
			'body'=>'required'
			]);

		$post = Post::find($request['postId']);
		
		if(Auth::user() != $post->user) {
			return redirect()->back();
		}

		$post->body = $request['body'];
		$post->update();
		return response()->json(['new_body'=>$post->body],200);
	}

	public function postLikePost(Request $request)
    {
        $post_id = $request['postId'];
        $is_like = $request['isLike'] === 'true';
        $update = false;
        $post = Post::find($post_id);

        if(!$post) {
        	return null;
        }
        $user = Auth::user();
        $like = $user->likes()->where('post_id', $post_id)->first();

        if($like) {
        	$already_like = $like->like;
        	$update = true;
        	if($already_like == $is_like) {
      			$like->delete();
      			return null;	  		
        	}
        } else {
        	$like = new Like;
        }
        $like->like = $is_like;
        $like->user_id = $user->id;
        $like->post_id = $post->id;

        if($update) {
        	$like->update();
        } else {
        	$like->save();
        }
        return null;
    }	
}


