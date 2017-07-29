	<?php
class Room extends Eloquent{
	//Database driver
		/*
			1 - Eloquent (MVC Driven)
			2 - DB (Directly query to SQL database, no model required)
		*/

	 	use SoftDeletingTrait;
		//The table in the database used by the model.
		protected $table = 'room';
   		protected $dates = ['deleted_at'];

		public $fillable = ['name','dimension'];
		public $timestamps = false;
		protected $primaryKey = 'id';
		//Validation rules!
		public static $rules = array(
			'Name' => 'required|min:4|max:100|unique:room,name',
			'Description' => 'required|min:4|max:100'
		);

		public static $updateRules = array(
			'Name' => 'min:4|max:100',
			'Description' => 'min:4|max:100'

		);

		public function roominventory()
		{
			return $this->hasMany('RoomInventory','room_id','id');
		}
}
