<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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



}