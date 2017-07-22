<?php

class SoftwareLicense extends Eloquent{
	
	protected $table = 'softwarelicense';
	
	public $timestamps = true;

	public $fillable = ['sofware_id','key','multipleuse','inuse'];
	protected $primaryKey = 'id';
	public static $rules = array(
		'Product Key' => 'required|string|min:5|max:100'
	);

	public static $updateRules = array(
		'Product Key' => 'string|min:5|max:100'
	);

	public static function install($id){
		$softwarelicense = SoftwareLicense::find($id);
		$softwarelicense->inuse = $softwarelicense->inuse + 1;
		$softwarelicense->save();
	}

	public static function uninstall($id){
		$softwarelicense = SoftwareLicense::find($id);
		if($softwarelicense->inuse > 0){
			$softwarelicense->inuse = $softwarelicense->inuse - 1;
		}
		$softwarelicense->save();
	}


}
