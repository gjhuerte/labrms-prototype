<?php

class Log extends Eloquent{
	protected $table = 'log';
	public $timestamps = true; 

	public $fillable = ['user_id','time','inout','computers','peripherals','light','aircon','clean','notes'];
	protected $primaryKey = 'id';
	public static $rules = array(
		'User id' => 'required|exists:user,id',
		'Notes' => ''
		
	); 

	public static $updateRules = array(
		
		'User id' => 'required|exists:user,id',
		'Notes' => ''
	);

	
}