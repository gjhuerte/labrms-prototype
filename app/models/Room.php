<?php
 use Illuminate\Database\Eloquent\SoftDeletingTrait;
class Room extends Eloquent{
		use SoftDeletingTrait;
	//Database driver
		/*
			1 - Eloquent (MVC Driven)
			2 - DB (Directly query to SQL database, no model required)
		*/

		//The table in the database used by the model.
		protected $table = 'room';
		protected $dates = ['deleted_at'];
		public $fillable = ['name','dimension'];
		public $timestamps = false;	
		//Validation rules!
		public static $rules = array(
			'name' => 'required|min:4|max:100|unique:room,name',
			'description' => ['required','min:4','max:100']
		);

		public static $updateRules = array(
			'name' => 'required|min:4|max:100',
			'description' => 'required|min:4|max:100'
			
		);
		
		public function schedule()
		{
			return $this->hasMany('Schedule','room_id','id')->first();
		}

		public function roomlog()
		{
			return $this->hasMany('Roomlog')->first();
		}

		public function roominventory()
		{
			return $this->hasMany('Roominventory','room_id','id');
		}
}