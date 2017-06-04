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
			return json_encode(User::where('type','faculty')->select('lastname','firstname','middlename','id')->get());
		}
		return View::make('faculty.index')
			->with('user',User::where('type','faculty')->select('lastname','firstname','middlename','contactnumber','email','accesslevel','status')->get())
			->with('active_tab','overview');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('faculty.create')
			->with('active_tab','add');
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
		if(isset($id)){
			$user = User::find($id);
			return View::make('faculty.update')
				->with('user',$user)
				->with('active_tab','update');
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
			'accesslevel' => '2',
			'type' => $type
		],User::$updateRules);

		if($validator->fails())
		{
			return Redirect::back()
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
		$user->type = $type;

		$user->save();

		Session::flash('success-message','Faculty information updated');
		return Redirect::to('faculty/view/update');
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
		Session::flash('success-message','Faculty removed from database');
		return Redirect::to('faculty/view/delete');
	}

	public function updateView()
	{
		return View::make('faculty.update-view')
			->with('user',User::where('type','faculty')->select('id','lastname','firstname','middlename','contactnumber','email','username','updated_at')->get())
			->with('active_tab','update');
	}

	public function deleteView()
	{
		return View::make('faculty.delete-view')
			->with('user',User::where('type','faculty')->where('id','!=','1')->select('id','lastname','firstname','middlename','contactnumber','email','username','updated_at')->get())
			->with('active_tab','remove');
	}


}
