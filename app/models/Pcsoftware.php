<?php

class Pcsoftware extends Eloquent{
	use SoftDeletingTrait;
	protected $table = 'pc_software';
	protected $dates = ['deleted_at'];
	public $timestamps = true;
	protected $primaryKey = 'id';
	public $fillable = ['pc_id','software_id','softwarelicense_id'];

	public static $rules = array(
		'PC ID' => 'exist:pc,id|required',
		'Software ID' => 'exist:software,id|required',
		'Software License ID' => 'exist:softwarelicense,id'
	);

	public static $updateRules = array(
		'PC ID' => 'exist:pc,id|required',
		'Software ID' => 'exist:software,id|required',
		'Software License ID' => 'exist:softwarelicense,id'
	);

	public function software()
	{
		return $this->belongsTo('software','software_id','id');
	}

	public function pc()
	{
		return $this->belongsTo('pc','pc_id','id');
	}


}
