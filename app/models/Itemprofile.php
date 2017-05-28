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


    public static function getUnassignedPropertyNumber($item)
    {
			// get the id from itemtype name
			$itemtype = Itemtype::where('name',$item)->select('id')->first();
			//get id from inventory
			$inventory = Inventory::where('itemtype_id',$itemtype->id)->select('id')->lists('id');

      if($item == 'System Unit'){
			     $itemprofile = Itemprofile::whereIn('inventory_id',$inventory)
                        ->whereNotIn('id',Pc::select('systemunit_id')->lists('systemunit_id'))
                        ->select('propertynumber')
                        ->get();
      }

      if($item == 'Display'){
			   $itemprofile = Itemprofile::whereIn('inventory_id',$inventory)
                        ->whereNotIn('id',Pc::select('monitor_id')->lists('monitor_id'))
                        ->select('propertynumber')
                        ->get();
      }

      if($item == 'AVR'){
        $itemprofile = Itemprofile::whereIn('inventory_id',$inventory)
                      ->whereNotIn('id',Pc::select('avr_id')->lists('avr_id'))
                      ->select('propertynumber')
                      ->get();
      }

      if($item == 'Keyboard'){

	      $itemprofile = Itemprofile::whereIn('inventory_id',$inventory)
                      ->whereNotIn('id',Pc::select('keyboard_id')->lists('keyboard_id'))
                      ->select('propertynumber')
                      ->get();
      }
      
			return json_encode($itemprofile);
    }

}
