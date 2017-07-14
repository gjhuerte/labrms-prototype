<?php

class AccountsAjaxController extends \BaseController {

	public function getAllAccount()
	{
		if(Request::ajax())
		{
			$user = User::select('id','username','lastname','firstname','middlename','email','contactnumber','type','accesslevel','status')->get();
			return json_encode(['data'=>$user]);
		}
	}

	public function getAllLaboratoryUsers()
	{
		if(Request::ajax())
		{
			$user = User::select('id','username','lastname','firstname','middlename','email','contactnumber','type','accesslevel','status')
					->whereIn('accesslevel',[0,1,2])
					->where('id','!=',Auth::user()->id)
					->get();
			return json_encode(['data'=>$user]);
		}
	}
}
