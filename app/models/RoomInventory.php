<?php

class RoomInventory extends Eloquent{
	use SoftDeletingTrait;
	protected $table = 'roominventory';
	protected $dates = ['deleted_at'];
	public $timestamps = true;
	public $fillable = ['room_id','item_id'];
	protected $primary = null;

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

	/**
	*
	*	Create a record on room inventory
	*	@param $location accepts location name / room name
	* 	@param item  accepts item id which exists in item profile
	*	@return roominventory details
	*
	*/
	public static function createRecord($location,$id)
	{
		/*
		*	fetch the room information
		*/
		$room = Room::location($location)->first();

		/*
		*	create a new record in room inventory
		*/
		$roominventory = Roominventory::create([
			'room_id' => $room->id,
			'item_id' => $id
		]);

		/*
		*	$room inventory contains the link
		*	between item and room id
		*/
		return $roominventory;
	}

}
