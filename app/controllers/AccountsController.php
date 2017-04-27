<?php

class AccountsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$user = User::all();
		return View::make('account.index')
			->with('user',$user)
			->with('active_tab','overview');	
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('account.create')
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
		$username = $this->sanitizeString(Input::get('username'));
		$contactnumber = $this->sanitizeString(Input::get('contactnumber'));
		$email = $this->sanitizeString(Input::get('email'));
		$password = $this->sanitizeString(Input::get('password'));
		$type = $this->sanitizeString(Input::get('type'));

		$validator = Validator::make([
			'Last name' => $lastname,
			'First name' => $firstname,
			'Middle name' => $middlename,
			'Username' => $username,
			'Contact number' => $contactnumber,
			'Email' => $email,
			'Password' => $password
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
		if($type == 'assistant')
		$user->accesslevel = '1';
		if($type == 'staff')
		$user->accesslevel = '2';
		if($type == 'faculty')
		$user->accesslevel = '3';
		if($type == 'student')
		$user->accesslevel = '4';
		$user->save();
		
		Session::flash("success-message","Account successfully created!");

		return Redirect::to('account/create')
			->with('active_tab','add');
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
			->with('user',$user)
			->with('active_tab','update');
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

		$user->save();
		
		Session::flash('success-message','Account information updated');
		return Redirect::to('account/all/edit');
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
		return Redirect::to('account/all/delete');
	}

	public function retrieveDeleted()
	{
		if(Request::ajax()){
			return User::onlyTrashed()->get();
		}

		$user = User::onlyTrashed()->get();
		return View::make('account.restore')
			->with('user',$user)
			->with('active_tab','restore');

	}

	public function restore($id)
	{
		if(Request::ajax()){

		}

		$id = $this->sanitizeString($id);

		//validates if id exist in database
		if(count(User::withTrashed()->find($id)) == 0)
		{
			Session::flash('error-message','Invalid ID');
			return Redirect::to('account/deleted/all');
		}
		$user = User::onlyTrashed()->find($id);
		$user->restore();
		Session::flash('success-message',"Account restored!");
        return Redirect::to('account/deleted/all');
	}

	public function retrieveInactiveAccount()
	{
		$user = User::where('status','=','0')->get();
		if(Request::ajax())
		{
			return json_encode($user);
		}

		return View::make('account.activate')
			->with('user',$user)
			->with('active_tab','activation');
	}

	public function activateAccount()
	{
		if(Request::ajax())
		{
			$id = $this->sanitizeString(Input::get('id'));
			$user = User::find($id);
			$user->status = 1;
			$user->save();
		}
	}

	public function updateView()
	{
		$user = User::where('username','!=','admin')->get();
		return View::make('account.update-view')
			->with('user',$user)
			->with('active_tab','update');		
	}

	public function deleteView()
	{
		$user = User::where('username','!=','admin')->get();
		return View::make('account.delete-view')
			->with('user',$user)
			->with('active_tab','remove');		
	}

	public function changeUserPassword()
	{
		if(Request::ajax())
		{
			$id = $this->sanitizeString(Input::get('id'));
		 	$user = User::find($id);
		 	$user->password = Hash::make('123456');
		 	$user->save();
		}
	}
}
