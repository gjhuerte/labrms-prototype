<?php

 use Illuminate\Database\Eloquent\SoftDeletingTrait;
class Roominventory extends Eloquent{
		use SoftDeletingTrait;

	protected $table = 'roominventory';
		protected $dates = ['deleted_at'];

	public $timestamps = true;

	public $fillable = ['room_id','item_id'];

	public static $rules = [
		'item' => 'required|exists:pc,id',
		'room' => 'required|exists:room,id'
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