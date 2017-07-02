<?php

class FacultyController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if(Request::ajax())
		{
			return json_encode([
				'data'=>User::where('type','faculty')->select('lastname','firstname','middlename','id','username','contactnumber','email','accesslevel')->get()
				]);
		}

		return View::make('faculty.index')
			->with('user',User::where('type','faculty')->select('lastname','firstname','middlename','username','contactnumber','email','accesslevel','status')->get());
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('faculty.create');
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
		$contactnumber = $this->sanitizeString(Input::get('contactnumber'));
		$email = $this->sanitizeString(Input::get('email'));
		$username = $this->sanitizeString(Input::get('username'));

		$validator = Validator::make([
			'Last name' => $lastname,
			'First name' => $firstname,
			'Middle name' => $middlename,
			'Contact number' => $contactnumber,
			'Email' => $email
		],Faculty::$rules);

		if($validator->fails())
		{
			return Redirect::to('account/create')
				->withErrors($validator)
				->withInput();
		}

		$user = new User;
		$user->username = $username;
		$user->password = Hash::make('12345678');
		$user->lastname = $lastname;
		$user->firstname = $firstname;
		$user->middlename = $middlename;
		$user->contactnumber = $contactnumber;
		$user->email = $email;
		$user->type = 'faculty';
		$user->status = '0';
		$user->save();

		Session::flash('success-message','Faculty Added');
		return Redirect::to('faculty');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		try {
			$user = User::find($id);
			return View::make('faculty.update')
				->with('user',$user);
		} catch (Exception $e) {
			Session::flash("error-message","Internal Error");
			return Redirect::to('dashboard');
		}
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		try{

			$id = $this->sanitizeString(Input::get('id'));
			$lastname = $this->sanitizeString(Input::get('lastname'));
			$firstname = $this->sanitizeString(Input::get('firstname'));
			$middlename = $this->sanitizeString(Input::get('middlename'));
			$contactnumber = $this->sanitizeString(Input::get('contactnumber'));
			$email = $this->sanitizeString(Input::get('email'));
			$type = $this->sanitizeString(Input::get('type'));
			$username = $this->sanitizeString(Input::get('username'));

			$validator = Validator::make([
				'last name' => $lastname,
				'first name' => $firstname,
				'middle name' => $middlename,
				'contact number' => $contactnumber,
				'email' => $email,
				'password' => 'dummypassword',
				'username' => 'sampleusernameonly',
				'accesslevel' => '2'
			],User::$updateRules);

			if($validator->fails())
			{
				return Redirect::to("faculty/$id/edit")
					->withInput()
					->withErrors($validator);
			}

			$user = User::find($id);
			$user->username = $username;
			$user->lastname = $lastname;
			$user->firstname = $firstname;
			$user->middlename = $middlename;
			$user->contactnumber = $contactnumber;
			$user->email = $email;

			$user->save();

			Session::flash('success-message','Faculty information updated');
			return Redirect::to('faculty');
		} catch (Exception $e) {

			Session::flash("error-message","Internal Error");
			return Redirect::to('dashboard');
		}
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{

		try{

			$user = User::find($id);
			$user->delete();
			return json_encode('success');

		} catch ( Exception $e ) {}

		$user = User::find($id);
		$user->delete();
		Session::flash('success-message','Faculty removed from database');
		return Redirect::to('faculty');
	}


}
