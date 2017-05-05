<?php
 use Illuminate\Database\Eloquent\SoftDeletingTrait;
class Pc extends Eloquent{
		use SoftDeletingTrait;
	//Database driver
		/*
			1 - Eloquent (MVC Driven)
			2 - DB (Directly query to SQL database, no model required)
		*/

		//The table in the database used by the model.
		protected $table = 'pc';
		protected $dates = ['deleted_at'];
		public $timestamps = true;
		public $fillable = ['keyboard','mouse'];
		//Validation rules!
		public static $rules = array(
			'name' => 'required|min:2|max:15',
			'keyboard' => 'boolean',
			'mouse' => 'boolean'
		);

		public static $updateRules = array(
			'keyboard' => 'boolean',
			'mouse' => 'boolean'
		);

		public function roominventory()
		{
			return $this->hasOne('Roominventory','room_id','id');
		}

		public function systemunit()
		{
			return $this->belongsTo('Itemprofile','systemunit_id','id');
		}

		public function display()
		{
			return $this->belongsTo('Itemprofile','display_id','id');
		}

}