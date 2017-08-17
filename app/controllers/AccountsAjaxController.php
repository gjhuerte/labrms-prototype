<?php

class AccountsAjaxController extends \BaseController {

	/**
	*
	*	@return list of username
	*	return value: 'data' => array(users)
	*
	*/
	public function getAllAccount()
	{
		if(Request::ajax())
		{
			$user = User::select('id','username','lastname','firstname','middlename','email','contactnumber','type','accesslevel','status')->get();
			return json_encode(['data'=>$user]);
		}
	}

	/**
	*
	*	@return laboratory users
	*	laboratory users ranges from 0 - 2
	*	0 - laboratory head
	*	1 - laboratory assistant
	*	2 - laboratory staff
	*
	*/
	public function getAllLaboratoryUsers()
	{
		if(Request::ajax())
		{
			/**
			*
			*	Note: Current user is not included
			*
			*/
			$user = User::select('id','username','lastname','firstname','middlename','email','contactnumber','type','accesslevel','status')
					->whereIn('accesslevel',[0,1,2])
					->where('id','!=',Auth::user()->id)
					->get();
			return json_encode(['data'=>$user]);
		}
	}
}
