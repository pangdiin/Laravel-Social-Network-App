<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
//home
Route::get('/', function () {
   	return view('welcome');
	})->name('home');
//signup
Route::post('/signup',['uses'=>'UserController@postSignUp','as'=>'signup']);
//signup
Route::post('/signin',['uses'=>'UserController@postSignIn','as'=>'signin']);
//logout
Route::get('/logout',['uses'=>'UserController@getLogout','as'=>'logout']);
// redirect to dashboard
Route::get('/dashboard',[
	'uses'=>'PostController@getDashboard',
	'as'=>'dashboard'])->middleware('auth');
//create post
Route::post('/createpost',[
	'uses'=>'PostController@postCreatePost',
	'as'=>'post.create',
	'middleware'=>'auth'
	]);

Route::get('/delete-post/{$id?}',['uses' => 'PostController@destroy','as' => 'post.destroy']);

Route::post('/edit', function(\Illuminate\Http\Request $request) {
	return response()->json(['message'=>$request['postId']]);
})->name('edit');
