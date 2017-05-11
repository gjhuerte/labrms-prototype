<?php

class Softwarelicense extends Eloquent{
	use SoftDeletingTrait;
	protected $table = 'softwarelicense';
	protected $dates = ['deleted_at'];
	public $timestamps = true;

	public $fillable = ['sofware_id','key','multipleuse','inuse'];
	protected $primaryKey = 'id';
	public static $rules = array(
		'Product Key' => 'required|string|min:5|max:100'
	);

	public static $updateRules = array(
		'Product Key' => 'string|min:5|max:100'
	);


}
