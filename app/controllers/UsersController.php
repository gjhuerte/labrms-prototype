<?php

class UsersController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
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
					'Current Password'=>'required',
					'New Password'=>'required'
				]
			);

		if( $validator->fails() )
		{
			Session::flash('error-message','Incorrect Password');
			return Redirect::back()
				->withInput()
				->withErrors($validator);
		}

		if(Hash::check($password,Auth::user()->password))
		{
			$user->password = Hash::make($newpassword);
			$user->save();
		}else{

			Session::flash('error-message','Incorrect Password');
			return Redirect::back()
				->withInput();
		}

		Session::flash('success-message','Password updated');
		return Redirect::back();
	}


}
