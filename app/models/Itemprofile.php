 <?php
class Itemprofile extends Eloquent{
	//Database driver
	/*
		1 - Eloquent (MVC Driven)
		2 - DB (Directly query to SQL database, no model required)
	*/
	use SoftDeletingTrait;
	//The table in the database used by the model.
	protected $table = 'itemprofile';
	protected $dates = ['deleted_at'];
	public $timestamps = true;
	public $fillable = ['property_number','serialid','location','datereceived','status'];
	//Validation rules!
	protected $primaryKey = 'id';
	public static $rules = array(
		'Property Number' => 'required|min:5|max:100|unique:itemprofile,propertynumber',
		'Serial Number' => 'required|min:5|max:100|unique:itemprofile,serialnumber',
		'Location' =>'required|min:5|max:100',
		'Date Received' =>'required|date',
		'Status' =>'required|min:5|max:50'

	);

	public static $updateRules = array(
		'Property Number' => 'min:5|max:100',
		'Serial Number' => 'min:5|max:100',
		'Location' =>'min:5|max:100',
		'Date Received' =>'date',
		'Status' =>'min:5|max:50'

	);

	public function inventory()
	{
		return $this->belongsTo('Inventory','inventory_id','id');
	}

	public function roominventory()
	{
		return $this->hasMany('Roominventory','item_id','id');
	}

	public function room()
	{
		return $this->belongsToMany('room','roominventory','item_id','room_id');
	}

  public static function data_null($propertynumber,$serialnumber,$location,$datereceived,$inventory_id,$receipt_id)
  {
		$itemprofile = new Itemprofile;
		$itemprofile->propertynumber = $propertynumber;
		$itemprofile->serialnumber = $serialnumber;
		$itemprofile->location = $location;
		$itemprofile->datereceived = Carbon\Carbon::parse($datereceived);
		$itemprofile->status = 'working';
		$itemprofile->inventory_id = $inventory_id;
		$itemprofile->receipt_id = $receipt_id;
		$itemprofile->save();
    //add to room inventory
		// $room = Room::where('name','=',$location)->first();
		// $roominventory = new Roominventory;
		// $roominventory->item_id = $itemprofile->id;
		// $roominventory->room_id = $room->id;
		// $roominventory->save();
  }

  public static function data($propertynumber,$serialnumber,$location,$datereceived,$inventory_id,$receipt_id)
  {
		$itemprofile = new Itemprofile;
		$itemprofile->propertynumber = $propertynumber;
		$itemprofile->serialnumber = $serialnumber;
		$itemprofile->location = $location;
		$itemprofile->datereceived = Carbon\Carbon::parse($datereceived);
		$itemprofile->status = 'working';
		$itemprofile->inventory_id = $inventory_id;
		$itemprofile->receipt_id = $receipt_id;
		$itemprofile->save();
    //add to room inventory
    Roominventory::data_null($location,$itemprofile->id);
    //set the inventory
    Inventory::addProfiled($inventory_id);
  }

  public static function getUnassignedPropertyNumber($item)
  {
    $itemprofile;
		// get the id from itemtype name
		$itemtype = Itemtype::where('name','=',$item)->select('id')->first();
		//get id from inventory
		$id = Inventory::where('itemtype_id','=',$itemtype->id)->select('id')->lists('id');
    //switch case items
    switch( $item ){
      //system unit
      case 'System Unit':
        $itemprofile = Itemprofile::getListOfItems($id,'systemunit_id','propertynumber');
        break;
      //monitor
      case 'Display':
        $itemprofile = Itemprofile::getListOfItems($id,'monitor_id','propertynumber');
        break;
      //avr
      case 'AVR':
        $itemprofile = Itemprofile::getListOfItems($id,'avr_id','propertynumber');
        break;
      //keyboard
      case $item == 'Keyboard':
        $itemprofile = Itemprofile::getListOfItems($id,'keyboard_id','propertynumber');
        break;
    }
		return json_encode($itemprofile);
  }

  public static function getListOfItems($id,$name,$item_to_select){
    $itemprofile = Itemprofile::whereIn('inventory_id',$id)
                  ->whereNotIn('id',Pc::select($name)->lists($name))
                  ->select('propertynumber')
                  ->get();
  }

}
