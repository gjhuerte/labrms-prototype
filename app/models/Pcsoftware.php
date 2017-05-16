<?php

class Pcsoftware extends Eloquent{
	use SoftDeletingTrait;
	protected $table = 'pc_software';
	protected $dates = ['deleted_at'];
	public $timestamps = true;
	protected $primaryKey = 'id';
	public $fillable = ['pc_id','software_id','softwarelicense_id'];

	public static $rules = array(
		'Pc Id' => 'exist:pc,id|required',
		'Software Id' => 'exist:software,id|required',
		'Software License Id' => 'exist:softwarelicense,id'
	);

	public static $updateRules = array(
		'Pc Id' => 'exist:pc,id|required',
		'Software Id' => 'exist:software,id|required',
		'Software License Id' => 'exist:softwarelicense,id'
	);

	
}