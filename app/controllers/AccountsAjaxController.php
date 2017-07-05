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
}
