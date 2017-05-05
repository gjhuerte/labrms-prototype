<?php

class AccountsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$user = User::where('username','!=','admin')->get();
		return View::make('account.index')
			->with('user',$user);	
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('account.create');
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

		$validator = Validator::make([
			'last name' => $lastname,
			'first name' => $firstname,
			'middle name' => $middlename,
			'username' => $username,
			'contact number' => $contactnumber,
			'email' => $email,
			'password' => Hash::make($password),
			'accesslevel' => '2',
			'type' => $type
		],User::$rules);

		if($validator->fails())
		{
			return Redirect::to('account/create')
				->withErrors($validator)
				->withInput();
		}

		$user = new User;
		$user->lastname = $lastname;
		$user->firstname = $firstname;
		$user->middlename = $middlename;
		$user->username = $username;
		$user->contactnumber = $contactnumber;
		$user->email = $email;
		$user->password = Hash::make($password);
		$user->type = $type; 
		$user->status = '1';
		$user->accesslevel = '2';
		$user->save();
		
		Session::flash("success-message","Account successfully created!");

		return Redirect::to('account');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$user = User::find($id);
		return View::make('account.show')
			->with('person',$user);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$user = User::find($id);
		return View::make('account.update')
			->with('user',$user);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$lastname = $this->sanitizeString(Input::get('lastname'));
		$firstname = $this->sanitizeString(Input::get('firstname'));
		$middlename = $this->sanitizeString(Input::get('middlename'));
		$contactnumber = $this->sanitizeString(Input::get('contactnumber'));
		$email = $this->sanitizeString(Input::get('email'));
		$type = $this->sanitizeString(Input::get('type'));

		$user = User::find($id);
		if(Input::get('status') == "Activate"){
			$user->status = '1';
		}elseif(Input::get('status') == "Deactivate"){
			$user->status = '0';
		}elseif(Input::get('access') == 'Set as admin'){
			$user->accesslevel = '1';
		}elseif(Input::get('access') == 'Set as regular user'){
			$user->accesslevel = '2';
		}else{

			$validator = Validator::make([
				'last name' => $lastname,
				'first name' => $firstname,
				'middle name' => $middlename,
				'contact number' => $contactnumber,
				'email' => $email,
				'password' => 'dummypassword',
				'username' => 'sampleusernameonly',
				'accesslevel' => '2',
				'type' => $type
			],User::$updateRules);

			if($validator->fails())
			{
				return Redirect::back()
					->withInput()
					->withErrors($validator);
			}

			$user->lastname = $lastname;
			$user->firstname = $firstname;
			$user->middlename = $middlename;
			$user->contactnumber = $contactnumber;
			$user->email = $email;
			$user->type = $type; 
			$user->status = '1';

		}

		$user->save();
		
		Session::flash('success-message','Account information updated');
		return Redirect::to('account');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$user = User::find($id);
		$user->delete();
		Session::flash('success-message','Account deleted!');
		return Redirect::to('account');
	}

}
