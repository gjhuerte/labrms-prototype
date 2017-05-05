 <?php
 use Illuminate\Database\Eloquent\SoftDeletingTrait;
class Inventory extends Eloquent{
		use SoftDeletingTrait;
	//Database driver
		/*
			1 - Eloquent (MVC Driven)
			2 - DB (Directly query to SQL database, no model required)
		*/

		//The table in the database used by the model.
		protected $table = 'inventory';
		protected $dates = ['deleted_at'];
		public $fillable = ['itemname','quantity','added','adjust','deduct','total'];
		public $timestamps = true;
		//Validation rules!
		public static $rules = array(
			'item name' => 'required|min:3|max:50|unique:inventory,itemname',
			'quantity' => 'required|min:5|max:450',
			'added' =>'numeric',
			'adjust' =>'numeric',
			'deduct' =>'numeric',
			'total' =>'numeric'

		);

		public static $updateRules = array(
			'item name' => 'required|min:3|max:50',
			'quantity' => 'required|min:5|max:450',
			'added' =>'numeric',
			'adjust' =>'numeric',
			'deduct' =>'numeric',
			'total' =>'numeric'
		);

		public function itemprofile()
		{
			return $this->hasMany('Itemprofile','inventory_id','id');
		}

		public function decreaseInventoryQuantity($id)
		{
			$inventory = Inventory::find($id);
			if($inventory->quantity > 0)
			$inventory->quantity = $inventory->quantity - 1;
			if($inventory->total > 0)
				$inventory->total = $inventory->total - 1;
			$inventory->deduct = $inventory->deduct + 1;
			$inventory->save();
		}

		public function increaseInventoryQuantity($id)
		{
			$inventory = Inventory::find($id);
			$inventory->quantity = $inventory->quantity + 1;
			$inventory->added = $inventory->added + 1;
			$inventory->total = $inventory->total + 1;
			$inventory->save();	
		}
}