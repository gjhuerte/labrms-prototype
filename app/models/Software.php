<?php

class Software extends Eloquent{
	use SoftDeletingTrait;
	protected $table = 'software';
	protected $dates = ['deleted_at'];
	public $timestamps = true;
	protected $primaryKey = 'id';
	public $fillable = ['softwarename','softwaretype','licensetype','company','minsysreq','maxsysreq'];

	public static $rules = array(
		'Software Name' => 'alpha|required|min: 2|max: 100',
		'Software Type' => 'alpha|required|min: 2|max: 100',
		'License Type' => 'alpha|required|min: 2|max: 100',
		'Company' => 'alpha|required|min: 2|max: 100',
		'Minimum System Requirement' => 'alpha|min: 2|max: 100',
		'Maximum System Requirement' => 'alpha|min: 2|max: 100'

	);

	public static $updateRules = array(
		'Software Name' => 'alpha|required|min: 2|max: 100',
		'Software Type' => 'alpha|required|min: 2|max: 100',
		'License Type' => 'alpha|required|min: 2|max: 100',
		'Company' => 'alpha|required|min: 2|max: 100',
		'Minimum System Requirement' => 'alpha|min: 2|max: 100',
		'Maximum System Requirement' => 'alpha|min: 2|max: 100'
	);

	public function softwarelicense(){
		return $this->hasOne('Softwarelicense');
	}


}
