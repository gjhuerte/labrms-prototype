<?php

class RoomLog extends Eloquent{
	protected $table = 'roomlog';
	public $timestamps = true; 

	public $fillable = ['user_id','room_id','workingunits','section','remark'];
	protected $primaryKey = 'id';
	public static $rules = array(
		'Login id' => 'required|exists:log,id',
		'Logout id' => 'exists:log,id',
		'Room Id' => 'required|exists:room,id',
		'Faculty in Charge' => 'required|numeric',
		'Section' => 'required|string|min:2|max:20',
	);

	public static $updateRules = array(
		'Login id' => 'required|exists:log,id',
		'Logout id' => 'exists:log,id',
		'Room Id' => 'required|exists:room,id',
		'Faculty in Charge' => 'required|numeric',
		'Section' => 'required|string|min:2|max:20',
	);

	
}