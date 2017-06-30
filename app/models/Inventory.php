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
			'Item Type' => 'required|exists:Itemtype,id',
			'Brand' => 'min:2|max:100',
			'Model' => 'min:2|max:100',
			'Details' => 'min:5|max:1000',
			'Warranty' => 'min:5|max:100',
			'Unit' => 'required',
			'Quantity' => 'required|numeric',
			'Profiled Items' => 'numeric'

		);

		public static $updateRules = array(
			'Item Type' => 'required|min:5|max:100',
			'Brand' => 'min:2|max:100',
			'Model' => 'min:2|max:100',
			'Details' => 'min:5|max:1000',
			'Warranty' => 'min:5|max:100',
			'Unit' => 'numeric',
			'Quantity' => 'numeric',
			'Profiled Items' => 'numeric'
		);

		public function itemprofile()
		{
			return $this->hasMany('Itemprofile','inventory_id','id');
		}

    public function itemtype()
    {
      return $this->belongsTo('Itemtype','itemtype_id','id');
    }

}
