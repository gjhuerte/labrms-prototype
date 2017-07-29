<?php

class RoomLog extends Eloquent{
	protected $table = 'roomlog';
	public $timestamps = true; 

	public $fillable = ['user_id','room_id','workingunits','section','remark'];
	protected $primaryKey = 'id';
	public static $rules = array(
		'Log id' => 'required|exists:log,id',
		'User Id' => 'required|exists:user,id',
		'Room Id' => 'required|exists:room,id',
		'Working Units' => 'required|numeric',
		'Section' => 'required|string|min:2|max:20',
		'Remark' => 'required|alpha|min:2|max:100'
	);

	public static $updateRules = array(
		'Log id' => 'required|exists:log,id',
		'User Id' => 'required|exists:user,id',
		'Room Id' => 'required|exists:room,id',
		'Working Units' => 'required|numeric',
		'Section' => 'required|string|min:2|max:20',
		'Remark' => 'required|alpha|min:2|max:100'
	);

	
}