<?php

class SessionsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('login');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('login');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

		$username = $this->sanitizeString(Input::get('username'));
		$password = $this->sanitizeString(Input::get('password'));

 		$user = User::where('username','=',$username)->first();

 		if(count($user) == 0)
 		{
			Session::flash('error-message','Invalid login credentials');
			return Redirect::to('login');
 		}

 		if($user->status == '0')
 		{

			Session::flash('error-message','Account Inactive. Contact the administrator to activate your account');
			return Redirect::to('login');

 		}
 		
		$user = array(	
			'username' => $username,
			'password' => $password
 		);

		if(Auth::attempt($user))
		{
			return Redirect::to('dashboard');
		}

		Session::flash('error-message','Invalid login credentials');
		return Redirect::to('login');

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
	public function edit()
	{
		return View::make('account.update');
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update()
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy()
	{
		//remove everything from session
		Session::flush();
		//remove everything from auth
		Auth::logout();
		return Redirect::to('/');
	}


}
