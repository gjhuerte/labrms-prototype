<?php

class SessionsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('pagenotfound');
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
		if(Request::ajax()){
			$username = $this->sanitizeString(Input::get('username'));
			$password = $this->sanitizeString(Input::get('password'));
 		
			$user = array(	
				'username' => $username,
				'password' => $password
	 		);

			if(Auth::attempt($user))
			{
	 			return 'success';
	 		}else{
	 			return 'error';
	 		}
		}

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
	public function show()
	{
		$person = Auth::user();
		return View::make('user.index')
			->with('person',$person);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit()
	{
		return View::make('user.edit');
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update()
	{
		$password = $this->sanitizeString(Input::get('password'));
		$newpassword = $this->sanitizeString(Input::get('newpassword'));

		$user = User::find(Auth::user()->id);

		$validator = Validator::make(
				[
					'Current Password'=>$password,
					'New Password'=>$newpassword
				],
				[
					'Current Password'=>'required|min:8|max:50',
					'New Password'=>'required|min:8|max:50'
				]
			);

		if( $validator->fails() )
		{
			return Redirect::back()
				->withInput()
				->withErrors($validator);
		}

		//verifies if password inputted is the same as the users password
		if(Hash::check($password,Auth::user()->password))
		{

			//verifies if current password is the same as the new password
			if(Hash::check($newpassword,Auth::user()->password)){
				Session::flash('error-message','Your New Password must not be the same as your Old Password');
				return Redirect::back()
					->withInput()
					->withErrors($validator);
			}else{

				$user->password = Hash::make($newpassword);
				$user->save();
			}
		}else{

			Session::flash('error-message','Incorrect Password');
			return Redirect::back()
				->withInput();
		}

		Session::flash('success-message','Password updated');
		return Redirect::back();
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
		return Redirect::to('login');
	}

	public function getResetForm(){
		return View::make('user.reset');
	}

	public function reset(){
		
	}

}
