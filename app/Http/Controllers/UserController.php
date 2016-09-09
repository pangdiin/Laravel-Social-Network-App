<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
	public function postSignUp(Request $request)
	{
		$this->validate($request, array(
			'email'=>'required',
			'first_name'=>'required|min:3|max:30',
			'password'=>'required'
			));

		$post = new User;

		$post->email = $request->email;
		$post->first_name = $request->first_name;
		$post->password = bcrypt($request->password);

		$post->save();

		// return redirect()->route();
		return redirect()->back();
	}

	public function postSignIn()
	{

	}
}