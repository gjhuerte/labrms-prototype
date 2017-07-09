 <?php
class Supplyhistory extends Eloquent{
	//Database driver
		/*
			1 - Eloquent (MVC Driven)
			2 - DB (Directly query to SQL database, no model required)
		*/
		use SoftDeletingTrait;
		//The table in the database used by the model.


		//The table in the database used by the model.
		protected $table = 'supplyhistory';
		protected $dates = ['deleted_at'];
		public $fillable = ['supply_id','unit','quantity','purpose','personinvolved'];
		public $timestamps = true;
		//Validation rules!
		
		public static $rules = array(
			'Unit' => 'required|alpha',
			'Quantity' => 'numeric',
			'Purpose' => 'required|min:2|max:100',
			'Person Involve' => 'required|min:5|max:1000'
		);

		public static $updateRules = array(
			'Unit' => 'alpha',
			'Quantity' => 'numeric',
			'Purpose' => 'min:2|max:100',
			'Person Involve' => 'min:5|max:1000'
		);
}
