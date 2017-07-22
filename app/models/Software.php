<?php

class Software extends Eloquent{

	protected $table = 'software';
	public $timestamps = true;
	protected $primaryKey = 'id';
	public $fillable = ['softwarename','softwaretype','licensetype','company','minsysreq','maxsysreq'];

	public static $rules = array(
		'Software Name' => 'alpha|required|min: 2|max: 100',
		'Software Type' => 'alpha|required|min: 2|max: 100|in:Programming,Database,Multimedia,Networking',
		'License Type' => 'alpha|required|min: 2|max: 100',
		'Company' => 'alpha|required|min: 2|max: 100',
		'Minimum System Requirement' => 'alpha|min: 2|max: 100',
		'Maximum System Requirement' => 'alpha|min: 2|max: 100'

	);

	public static $updateRules = array(
		'Software Name' => 'alpha|required|min: 2|max: 100',
		'Software Type' => 'alpha|required|min: 2|max: 100|in:Programming,Database,Multimedia,Networking',
		'License Type' => 'alpha|required|min: 2|max: 100',
		'Company' => 'alpha|required|min: 2|max: 100',
		'Minimum System Requirement' => 'alpha|min: 2|max: 100',
		'Maximum System Requirement' => 'alpha|min: 2|max: 100'
	);

	public static $types = [
			'Programming',
			'Database',
			'Multimedia',
			'Networking'
	];

	public function softwarelicense(){
		return $this->hasMany('SoftwareLicense');
	}

	public function roomsoftware(){
		return $this->hasMany('RoomSoftware');
	}

	public function room(){
		return $this->belongsToMany('Room');
	}

	public function getSoftwareTypes()
	{
		$types = Software::$types;
		return compact($types);
	}


}
