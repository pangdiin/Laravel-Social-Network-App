@extends('layouts.master')

@section('title','Homepage')

@section('content')
		<div class="row">
			<div class="col-md-6">
				<h3>Sign Up</h3>
				<form action="{{ route('signup') }}" method="POST">
				{{-- {{ csrf_field() }} --}}
					<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
						<label for="email">Your E-mail</label>
						<input type="text" name="email" id="email" class="form-control" value="{{ old('email') }}">
					</div>
					<div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
						<label for="first_name">Your First Name</label>
						<input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name') }}">
					</div>
					<div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
						<label for="password">Password</label>
						<input type="password" name="password" id="password" class="form-control">
					</div>
					<button type="submit" class="btn btn-primary">Submit</button>
					<input type="hidden" name="_token" value="{{ Session::token() }}">
				</form>
			</div>
			<div class="col-md-6">
				<h3>Sign In</h3>
				<form action="{{ route('signin') }}" method="POST">
					<div class="form-group">
						<label for="email">Your E-mail</label>
						<input type="text" name="email" id="email" class="form-control">
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" name="password" id="password" class="form-control">
					</div>
					<button type="submit" class="btn btn-primary pull-right">Submit</button>
					<input type="hidden" name="_token" value="{{ Session::token() }}">
				</form>
			</div>
		</div>
@endsection