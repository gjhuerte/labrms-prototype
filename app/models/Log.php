<?php

class Log extends Eloquent{
	use SoftDeletingTrait;
	protected $table = 'log';
	protected $dates = ['deleted_at'];
	public $timestamps = true; 

	public $fillable = ['timein','timeout'];
	protected $primaryKey = 'id';
	public static $rules = array(

		'timein' => 'required',
		'timeout' => 'required'
		
	);

	public static $updateRules = array(
		
		'timein' => 'required',
		'timeout' => 'required'
	);

	
}