<?php

class AccountsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('account.index');
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

		User::createRecord($username,$password,$lastname,$firstname,$middlename,$contactnumber,$email,$type);

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
		if(isset($id)){
			$user = User::find($id);
			return View::make('account.update')
				->with('user',$user);
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
			'accesslevel' => '2',
			'type' => $type
		],User::$updateRules);

		if($validator->fails())
		{
			return Redirect::back()
				->withInput()
				->withErrors($validator);
		}

		User::updateRecord($id,$username,$lastname,$firstname,$middlename,$contactnumber,$email,$type);

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
		if(Request::ajax()){
			try{

				$user = User::select('id')->get();
				if($id == Auth::user()->id){
					return json_encode('self');
				}else if(count($user) <= 1){
					return json_encode('invalid');
				}else{
					$user = User::find($id);
					$user->delete();
					return json_encode('success');
				}
			} catch (Exception $e) {}
		}

		try{
			$user = User::find($id);
			$user->delete();
		} catch (Exception $e) {
			Session::flash('error_message','Error Ocurred while processing your data');
			return Redirect::back();
		}
		Session::flash('success-message','Account deleted!');
		return Redirect::to('account/view/delete');
	}

	/**
	 * Display a list of deleted account
	 *
	 * @return Response
	 */
	public function retrieveDeleted()
	{
		if(Request::ajax()){
			return User::onlyTrashed()->get();
		}

		$user = User::onlyTrashed()->get();
		return View::make('account.restore')
			->with('user',$user);

	}

	/**
	 *Restore Deleted Account
	 *
	 *
	 */

	public function restore($id)
	{
		$id = $this->sanitizeString($id);

		//validates if id exist in database
		if(count(User::withTrashed()->find($id)) == 0)
		{
			Session::flash('error-message','Invalid ID');
			return Redirect::to('account/view/deleted');
		}
		$user = User::onlyTrashed()->find($id);
		$user->restore();
		Session::flash('success-message',"Account restored!");
        return Redirect::to('account/view/deleted');
	}

	/**
	 * Activate or deactivate account
	 *
	 *@param  int  $type
	 *@param  int  $id
	 * @return Response
	 */
	public function activateAccount($id)
	{
		if(Request::ajax())
		{
			if($id == Auth::user()->id){
				return json_encode('self');
			}else{

				$type = $this->sanitizeString(Input::get('type'));
				$user = User::find($id);

				if($type == 'activate')
				{
					$user->status = 1;
					$user->save();
					return json_encode('activated');
				} 
				else if($type == 'deactivate') 
				{
					$user->status = 0;
					$user->save();
					return json_encode('deactivated');
				}
			}
		}
	}
	
	/**
	 * Change User Password to Default '12345678'
	 *
	 * user id
	 *@param  int  $id
	 */
	public function resetPassword()
	{
		if(Request::ajax())
		{
			$id = $this->sanitizeString(Input::get('id'));
		 	$user = User::find($id);
		 	$user->password = Hash::make('12345678');
		 	$user->save();

		 	return json_encode('success');
		}
	}

	public function changeAccessLevel()
	{
		$id = $this->sanitizeString(Input::get("id"));
		$access = $this->sanitizeString(Input::get('newaccesslevel'));

		try {

			if(Auth::user()->accesslevel != 0){

				Session::flash('error-message','You do not have enough priviledge to switch to this level');
				return Redirect::to('account');
			}
			
			$user = User::find($id);
			$user->accesslevel = $access;
			$user->save();

			Session::flash('success-message','Access Level Switched');
			return Redirect::to('account');
		} catch (Exception $e){

			Session::flash('error-message','Error occurred while switching access level');
			return Redirect::to('account');
		}
	}
}
