<?php
class Supply extends Eloquent{
	//Database driver
		/*
			1 - Eloquent (MVC Driven)
			2 - DB (Directly query to SQL database, no model required)
		*/
		//The table in the database used by the model.


		//The table in the database used by the model.
		protected $table = 'supply';
		public $fillable = ['brand','unit','quantity'];
		public $timestamps = true;
		//Validation rules!
		protected $primaryKey = 'id';
		public static $rules = array(
			'Item Type' => 'required|exists:Itemtype,id',
			'Brand' => 'min:2|max:100',
			'Unit' => 'required|alpha',
			'Quantity' => 'required|numeric',

		);

		public static $updateRules = array(
			'Item Type' => 'min:5|max:100',
			'Brand' => 'min:2|max:100',
			'Unit' => 'alpha',
			'Quantity' => 'numeric'
		);

		public function itemtype()
		{
			return $this->hasOne('itemtype','id','itemtype_id');
		}
}
