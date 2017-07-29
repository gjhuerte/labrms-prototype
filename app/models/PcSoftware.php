<?php

class PcSoftware extends Eloquent{
	use SoftDeletingTrait;
	protected $table = 'pc_software';
	protected $dates = ['deleted_at'];
	public $timestamps = true;
	protected $primaryKey = 'id';
	public $fillable = ['pc_id','software_id','softwarelicense_id'];

	public static $rules = array(
		'PC ID' => 'exists:pc,id|required',
		'Software ID' => 'exists:software,id|required',
		'Software License ID' => 'exists:softwarelicense,id'
	);

	public static $updateRules = array(
		'PC ID' => 'exists:pc,id|required',
		'Software ID' => 'exists:software,id|required',
		'Software License ID' => 'exists:softwarelicense,id'
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
