<?php

class Faculty extends Eloquent{

  protected $table = 'facultyview';

	public $timestamps = true;

	protected $fillable = ['lastname','firstname','middlename','username','password','contactnumber','email','type','status','accesslevel'];

	protected $hidden = ['password','remember_token'];
	//Validation rules!
	public static $rules = array(
		'Username' => 'min:4|max:20|unique:User,username',
		'Password' => 'min:8|max:50',
		'First name' => 'required|between:2,100|string',
		'Middle name' => 'min:2|max:50|string',
		'Last name' => 'required|min:2|max:50|string',
		'Contact number' => 'required|size:11|string',
		'Email' => 'required|email'
	);

	public static $updateRules = array(
		'Username' => 'min:4|max:20',
		'Password' => 'min:6|max:50',
		'First name' => 'min:2|max:100|string',
		'Middle name' => 'min:2|max:50|string',
		'Last name' => 'min:2|max:50|string',
		'Contact number' => 'size:11|string',
		'email' => 'email'
	);

}
