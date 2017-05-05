<?php

class SignupController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('signup');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{		
		$lastname = $this->sanitizeString(Input::get('lastname'));
		$firstname = $this->sanitizeString(Input::get('firstname'));
		$middlename = $this->sanitizeString(Input::get('middlename'));
		$username = $this->sanitizeString(Input::get('username'));
		$contactnumber = $this->sanitizeString(Input::get('contactnumber'));
		$email = $this->sanitizeString(Input::get('email'));
		$password = $this->sanitizeString(Input::get('password'));
		$type = $this->sanitizeString(Input::get('type'));
		$confirm = $this->sanitizeString(Input::get('confirm'));

		$user = [
			'username' => $username,
			'password' => $password,
			'last name' => $lastname,
			'first name' => $firstname,
			'middle name' => $middlename,
			'contact number' => $contactnumber,
			'email' => $email
		];
		
		$validator = Validator::make($user,User::$rules);

		if($validator->fails())
		{
			return Redirect::to('register')
				->withErrors($validator)
				->withInput();
		}

		if( empty($confirm) || $confirm == null)
		{
			return Redirect::to('register')
				->withErrors("Password needs confirmation")
				->withInput();
		}

		if( $password != $confirm )
		{
			return Redirect::to('register')
				->withErrors("Password mismatch!")
				->withInput();
		}

		$user = new User;
		$user->username = $username;
		$user->lastname = $lastname;
		$user->firstname = $firstname;
		$user->middlename = $middlename;
		$user->contactnumber = $contactnumber;
		$user->email = $email;
		$user->password = Hash::make($password);
		$user->accesslevel = "2";
		$user->type = $type; 
		$user->save();
		
		Session::flash("success-message","Account successfully created! Contact the administrator to activate your account");

		return Redirect::to('login');
	}


}
