<?php

class ItemLog extends Eloquent{
	protected $table = 'itemlog';
	public $timestamps = true; 

	public $fillable = ['log_id','item_id','facultyincharge','remark'];
	protected $primaryKey = 'id';
	public static $rules = array(

		'Log id' => 'required|exists:log,id',
		'Item Id' => 'required|exists:itemprofile,id',
		'Faculty In Charge' => 'alpha|min:5|max:100',
		'Remark' => 'alpha|min:5|max:200'
		
	);

	public static $updateRules = array(
		'Log id' => 'required|exists:log,id',
		'Item Id' => 'required|exists:itemprofile,id',
		'Faculty In Charge' => 'alpha|min:5|max:100',
		'Remark' => 'alpha|min:5|max:200'
	);


}