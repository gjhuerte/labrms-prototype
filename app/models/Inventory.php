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

    public static function data($_inventory,$_receipt)
    {
      //initiate inventory
      $inventory;
      //try if inventory already exists
  		try {
        //update the quantity
    		$inventory = Inventory::find($_inventory['model']);
  			$inventory->quantity = $inventory->quantity + $quantity;
    		$inventory->save();
  		} catch( Exception $e ){
        //create new inventory
  			$inventory = new Inventory;
  			$inventory->brand = $_inventory['brand'];
  			$inventory->itemtype_id = $_inventory['itemtype'];
  			$inventory->model = $_inventory['model'];
  			$inventory->quantity = $_inventory['quantity'];
  			$inventory->unit = $_inventory['unit'];
  			$inventory->warranty = $_inventory['warranty'];
  			$inventory->details = $_inventory['details'];
    		$inventory->save();
  		}
      //create receipt
      $receipt = new Receipt;
    	$receipt->number = $_receipt['number'];
    	$receipt->pono = $_receipt['ponumber'];
    	$receipt->podate = $_receipt['podate'];
    	$receipt->invoiceno = $_receipt['invoicenumber'];
    	$receipt->invoicedate = $_receipt['invoicedate'];
    	$receipt->fundcode = $_receipt['fundcode'];
      $receipt->inventory_id = $inventory->id;
      $receipt->save();
      //current date
      $datereceived = Carbon\Carbon::now()->toFormattedDateString();
      //add item in database but set as null
      // for($ctr = 0; $ctr < $_inventory['quantity']; $ctr++){
		  //   Itemprofile::data_null(null,null,'Server',$datereceived,$inventory->id,$receipt->id);
      // }

    }

    public static function addProfiled($inventory_id)
    {
  		$inventory = Inventory::find($inventory_id);
  		$inventory->profileditems = $inventory->profileditems + 1;
  		$inventory->save();
    }

    public static function removeProfiled($inventory_id)
    {
  		$inventory = Inventory::find($inventory_id);
  		$inventory->profileditems = $inventory->profileditems - 1;
  		$inventory->save();
    }

		public function itemprofile()
		{
			return $this->hasMany('Itemprofile','inventory_id','id');
		}

    public function itemtype()
    {
      return $this->belongsTo('Itemtype','itemtype_id','id');
    }

}
