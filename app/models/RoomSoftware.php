<?php

class RoomSoftware extends Eloquent{
	use SoftDeletingTrait;
	protected $table = 'room_software';
	protected $dates = ['deleted_at'];
	public $timestamps = true;
	protected $primaryKey = 'id';
	public $fillable = ['room_id','software_id','softwarelicense_id'];

	public static $rules = array(
		'Room' => 'exists:room,id|required',
		'Software ID' => 'exists:software,id|required',
		'Software License ID' => 'exists:softwarelicense,id'
	);

	public static $updateRules = array(
		'Room' => 'exists:room,id|required',
		'Software ID' => 'exists:software,id|required',
		'Software License ID' => 'exists:softwarelicense,id'
	);

	public function software()
	{
		return $this->belongsTo('software','software_id','id');
	}

	public function room()
	{
		return $this->belongsTo('room','room_id','id');
	}


}
