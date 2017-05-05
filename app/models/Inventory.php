 <?php
class Inventory extends Eloquent{
	//Database driver
		/*
			1 - Eloquent (MVC Driven)
			2 - DB (Directly query to SQL database, no model required)
		*/ 
		use SoftDeletingTrait;
		//The table in the database used by the model.
		
   		
		//The table in the database used by the model.
		protected $table = 'inventory';
		protected $dates = ['deleted_at'];
		public $fillable = ['itemtype','brand','model','details','warranty','unit','quantity','profileditems'];
		public $timestamps = true;
		//Validation rules!
		protected $primaryKey = 'id';
		public static $rules = array(
			'Item Type' => 'required|min:5|max:100|alpha',
			'Brand' => 'min:2|max:100|alpha',
			'Model' => 'min:2|max:100|alpha',
			'Details' => 'min:5|max:1000|alpha',
			'Warranty' => 'min:5|max:100|alpha',
			'Unit' => 'required',
			'Quantity' => 'required|numeric',
			'Profiled Items' => 'numeric'

		);

		public static $updateRules = array(
			'Item Type' => 'required|min:5|max:100|alpha',
			'Brand' => 'min:2|max:100|alpha',
			'Model' => 'min:2|max:100|alpha',
			'Details' => 'min:5|max:1000|alpha',
			'Warranty' => 'min:5|max:100|alpha',
			'Unit' => 'required|numeric',
			'Quantity' => 'required|numeric',
			'Profiled Items' => 'numeric'
		);

		public function itemprofile()
		{
			return $this->hasMany('Itemprofile','inventory_id','id');
		}

}