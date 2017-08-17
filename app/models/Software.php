<?php

class Software extends Eloquent{

	protected $table = 'software';
	public $timestamps = true;
	protected $primaryKey = 'id';
	public $fillable = ['softwarename','softwaretype','licensetype','company','minsysreq','maxsysreq'];

	public static $rules = array(
		'Software Name' => 'required|min: 2|max: 100',
		'Software Type' => 'required|min: 2|max: 100|in:Programming,Database,Multimedia,Networking',
		'License Type' => 'required|min: 2|max: 100',
		'Company' => 'min: 2|max: 100',
		'Minimum System Requirement' => 'min: 2|max: 100',
		'Maximum System Requirement' => 'min: 2|max: 100'

	);

	public static $updateRules = array(
		'Software Name' => 'alpha|min: 2|max: 100',
		'Software Type' => 'alpha|min: 2|max: 100|in:Programming,Database,Multimedia,Networking',
		'License Type' => 'alpha|min: 2|max: 100',
		'Company' => 'alpha|min: 2|max: 100',
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

	public function pcsoftware(){
		return $this->hasOne('PcSoftware','software_id','id');
	}

	public function pc()
	{
		return $this->belongsToMany('Pc','software_software','pc_id','pc_id')->withPivot('softwarelicense_id')->withTimestamps();
	}

	public function getSoftwareTypes()
	{
		$types = Software::$types;
		return compact($types);
	}


}
