<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
	public function postSignUp(Request $request)
	{
		$this->validate($request, array(
			'email'=>'required|email|unique:users',
			'first_name'=>'required|min:3|max:120',
			'password'=>'required|min:4'
			));

		$user = new User;

		$user->email = $request->email;
		$user->first_name = $request->first_name;
		$user->password = bcrypt($request->password);

		$user->save();

		Auth::login($user);
		// Auth::logout($user);

		return redirect()->route('dashboard');
		// return redirect()->back();
	}

	public function postSignIn(Request $request)
	{
		$this->validate($request,[
			'email'=>'required|email',
			'password'=>'required'
			]);

		if(Auth::attempt(['email'=>$request->email, 'password'=>$request->password]))
		{
			return redirect()->route('dashboard');
		} else {

			return redirect()->back();
		}
	}
	public function getLogout()
	{
		Auth::logout();
		return redirect()->route('home');
	}

	public function getAccount()
	{
		return view('account',['user'=> Auth::user()]);
	}

	public function postSaveAccount(Request $request)
	{
		$this->validate($request,[
			'first_name'=>'required|max:120'
			]);

		$user = Auth::user();
		$user->first_name = $request->first_name;
		$user->update();

		$file = $request->file('image');
		$filename = $request->first_name . '-' . $user->id . '.jpg';

		if($file) {
			Storage::disk('local')->put($filename,File::get($file));
		}

		return redirect()->route('account');
	}

	public function getUserImage($filename)
	{	
		$file = Storage::disk('local')->get($filename);
		return  new Response($file, 200);
	}

}