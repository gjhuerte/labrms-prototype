<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
 use Illuminate\Database\Eloquent\SoftDeletingTrait;

class User extends Eloquent implements UserInterface, RemindableInterface {
	use UserTrait, RemindableTrait, SoftDeletingTrait;

	//Database driver
	/*
		1 - Eloquent (MVC Driven)
		2 - DB (Directly query to SQL database, no model required)
	*/

	//The table in the database used by the model.
	protected $table  = 'user';
		protected $dates = ['deleted_at'];

	//The attribute that used as primary key.
	protected $primaryKey = 'id';

	public $timestamps = true;

	protected $fillable = ['lastname','firstname','middlename','username','password','contactnumber','email','type','status','accesslevel'];

	protected $hidden = ['password','remember_token'];
	//Validation rules!
	public static $rules = array(
		'username' => 'required|min:4|max:20|unique:User,username',
		'password' => array('required','between:2,100'),
		'first name' => 'required|between:2,100|string',
		'middle name' => 'required|between:2,50|string',
		'last name' => 'required|between:2,50|string',
		'contact number' => 'required|size:11|string',
		'email' => 'required|email'
	);

	public static $updateRules = array(
		'username' => 'required|min:4|max:20',
		'password' => 'required|between:2,100',
		'first name' => 'required|between:2,100|string',
		'middle name' => 'required|between:2,50|string',
		'last name' => 'required|between:2,50|string',
		'contact number' => 'required|size:11|string',
		'email' => 'required|email'
	);


	public function getRememberToken()
	{
		return null; // not supported
	}

	public function setRememberToken($value)
	{
		// not supported
	}

	public function getRememberTokenName()
	{
		return null; // not supported
	}

	/**
	* Overrides the method to ignore the remember token.
	*/
	public function setAttribute($key, $value)
	{
		$isRememberTokenAttribute = $key == $this->getRememberTokenName();
		if (!$isRememberTokenAttribute)
		{
		 parent::setAttribute($key, $value);
		}
	}

	public function reservation()
	{
		return $this->hasOne('Reservation','user_id');
	}

	public function itemprofile()
	{
		return $this->belongsToMany('Itemprofile','Reservation','user_id','item_id');
	}
}