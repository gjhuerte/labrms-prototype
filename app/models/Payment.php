<?php

class Payment extends Eloquent{
	use SoftDeletingTrait;
	protected $table = 'payment';
	protected $dates = ['deleted_at'];
	public $timestamps = true;

	public $fillable = ['item_id','ORno','receivedby','details','amount'];
	protected $primaryKey = 'id';
	public static $rules = array(
		'Item id' => 'exists:itemprofile,id|required',
		'OR number' => 'required|string|unique:payment,ORno',
		'Received by' => 'required|alpha',
		'Details' => 'required|alpha',
		'Amount' => 'required|numeric'

	);

	public static $updateRules = array(
		
		'Item id' => 'exists:itemprofile,id|required',
		'OR number' => 'required|string|unique:payment,ORno',
		'Received by' => 'required|alpha',
		'Details' => 'required|alpha',
		'Amount' => 'required|numeric'
	);

	
}