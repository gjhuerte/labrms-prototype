<?php

class Roominventory extends Eloquent{
	use SoftDeletingTrait;
	protected $table = 'roominventory';
	protected $dates = ['deleted_at'];
	public $timestamps = true;
	public $fillable = ['room_id','item_id'];

	public static $rules = [
		'Item' => 'required|exists:itemprofile,id',
		'Room' => 'required|exists:room,id'
	];

	public static $updateRules = [
		'Item' => 'exists:itemprofile,id',
		'Room' => 'exists:room,id'
	];

	public function room()
	{
		return $this->belongsTo('room','room_id','id');
	}

	public function pc()
	{
		return $this->belongsTo('pc','item_id','id');
	}

}
