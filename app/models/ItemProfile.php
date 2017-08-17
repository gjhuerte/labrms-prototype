 <?php
class ItemProfile extends Eloquent{
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

	/*
	*
	*	Foreign key referencing inventory table
	*
	*/
	public function inventory()
	{
		return $this->belongsTo('Inventory','inventory_id','id');
	}

	/*
	*
	*	Foreign key referencing roominventory table
	*
	*/
	public function roominventory()
	{
		return $this->hasOne('RoomInventory','item_id','id');
	}

	/*
	*
	*	Foreign key referencing receipt table
	*
	*/
	public function receipt()
	{
		return $this->belongsTo('Receipt','receipt_id','id');
	}

	/*
	*
	*	Foreign key referencing room table
	*
	*/
	public function room()
	{
		return $this->belongsToMany('room','roominventory','item_id','room_id');
	}

	/*
	*
	*	Foreign key referencing ticket table
	*
	*/
	public function itemticket()
	{
		return $this->hasMany('ItemTicket','item_id','id');
	}

	/*
	*
	*	Foreign key referencing ticket table
	*
	*/
	public function ticket()
	{
		return $this->belongsToMany('Ticket','item_ticket','item_id','ticket_id');
	}

	/*
	*
	*	Limit the scope by propertynumber
	*	usage: ItemProfile::propertyNumber($propertynumber)->get()
	*
	*/
	public function scopePropertyNumber($query,$propertynumber)
	{
		return $query->where('propertynumber','=',$propertynumber);
	}

	/**
	*
	*	@param $propertynumber
	*	@param $serialnumber
	*	@param $location name
	*	@param $datereceived
	*	@param $inventory_id referencing inventory table
	*	@param $receipt_id referencing receipt table
	*
	*/
	public static function createRecord($propertynumber,$serialnumber,$location,$datereceived,$inventory_id,$receipt_id)
	{
		/**
		*
		*	Pass the parameters to transaction / stored procedure 
		*
		*/
		DB::transaction(function() use ($propertynumber,$serialnumber,$location,$datereceived,$inventory_id,$receipt_id)
		{
			/**
			*
			*	Create a record on item profile table
			*	@param $propertynumber
			*	@param $serialnumber
			*	@param $location name
			*	@param $datereceived
			*	@param $inventory_id referencing inventory table
			*	@param $receipt_id referencing receipt table
			*
			*/
			$itemprofile = ItemProfile::createItemProfile(
						$propertynumber,
						$serialnumber,
						$location,
						$datereceived,
						$inventory_id,
						$receipt_id
					);

			/*
			|--------------------------------------------------------------------------
			|
			| 	Create initial ticket
			|
			|--------------------------------------------------------------------------
			|
			*/
			ItemProfile::createProfilingTicket($itemprofile->id,$datereceived);
		    
			/*
			|--------------------------------------------------------------------------
			|
			| 	Set the location of the item
			|
			|--------------------------------------------------------------------------
			|
			*/
		    RoomInventory::createRecord($location,$itemprofile->id);

			/*
			|--------------------------------------------------------------------------
			|
			| 	Add 1 to profiled items count
			|	Used to check if how many items are not yet profiled
			|	Located in inventory table
			|
			|--------------------------------------------------------------------------
			|
			*/
		    Inventory::addProfiled($inventory_id);
		});
	}

	/*
	*
	*	Create a profiling ticket
	*	Send item id from create record to this
	*
	*/
	public static function createProfilingTicket($item_id,$datereceived)
	{
		$fullname = Auth::user()->firstname . " " . Auth::user()->middlename . " " . Auth::user()->lastname; 
		$datereceived = Carbon\Carbon::parse($datereceived)->toFormattedDateString();
		$details = "Equipment profiled on ".$datereceived. " by ". $fullname . ". ";
		$tickettype = 'receive';
		$ticketname = 'Equipment Profiling';
		$staffassigned = Auth::user()->id;
		$ticket_id = null;
		$status = 'Closed';

		/*
		|--------------------------------------------------------------------------
		|
		| 	Calls the function generate equipment ticket
		|
		|--------------------------------------------------------------------------
		|
		*/
		Ticket::generateEquipmentTicket($item_id,$tickettype,$ticketname,$details,$fullname,$staffassigned,$ticket_id,$status);
	}

	/**
	*
	*	@param $propertynumber
	*	@param $serialnumber
	*	@param $location name
	*	@param $datereceived
	*	@param $inventory_id referencing inventory table
	*	@param $receipt_id referencing receipt table
	*
	*/
	public static function createItemProfile($propertynumber,$serialnumber,$location,$datereceived,$inventory_id,$receipt_id)
	{
		$datereceived = Carbon\Carbon::parse($datereceived);
		$itemprofile = new ItemProfile;
		$itemprofile->propertynumber = $propertynumber;
		$itemprofile->serialnumber = $serialnumber;
		$itemprofile->location = $location;
		$itemprofile->datereceived = $datereceived;
		$itemprofile->status = 'working';
		$itemprofile->inventory_id = $inventory_id;
		$itemprofile->receipt_id = $receipt_id;
		$itemprofile->save();	

		/*
		|--------------------------------------------------------------------------
		| return collection of profiled item
		|--------------------------------------------------------------------------
		|
		*/
		return $itemprofile;
	}

	/**
	*
	*	@param $item accepts item type name
	*	@return returns the list of propertynumber of type
	*
	*/
	public static function getUnassignedPropertyNumber($item)
	{
		/*
		*
		*	Initialize item profile
		*
		*/
		$itemprofile;

		/**
		*
		*	queries all the itemtypes 
		*	select only the top 
		*	@return id
		*
		*/
		$itemtype = ItemType::type($item)->select('id')->first();

		/**
		*
		*	after selecting the itemtype where the item belongs
		*	lists all the id on the inventory
		*	where the item type belongs
		*
		*/
		$id = Inventory::where('itemtype_id','=',$itemtype->id)->select('id')->lists('id');
		//switch case items
		switch( $item ){

			/*
			|--------------------------------------------------------------------------
			| System Unit
			|--------------------------------------------------------------------------
			|
			*/
			case 'System Unit':
			$itemprofile = ItemProfile::getListOfItems($id,'systemunit_id');
			break;


			/*
			|--------------------------------------------------------------------------
			| Monitor
			|--------------------------------------------------------------------------
			|
			*/
			case 'Display':
			$itemprofile = ItemProfile::getListOfItems($id,'monitor_id');
			break;

			/*
			|--------------------------------------------------------------------------
			| AVR
			|--------------------------------------------------------------------------
			|
			*/
			case 'AVR':
			$itemprofile = ItemProfile::getListOfItems($id,'avr_id');
			break;

			/*
			|--------------------------------------------------------------------------
			| Keyboard
			|--------------------------------------------------------------------------
			|
			*/
			case $item == 'Keyboard':
			$itemprofile = ItemProfile::getListOfItems($id,'keyboard_id');
			break;
		}

		/*
		*
		*	return collection of item profile
		*
		*/
		return json_encode($itemprofile);
	}

	/**
	*
	*	@param $id accepts item profile id
	*	@param $name filter the lists returned
	*	@return collection of $name from $id found
	*
	*/
	public static function getListOfItems($id,$name){
	$itemprofile = ItemProfile::whereIn('inventory_id',$id)
	              ->whereNotIn('id',Pc::select($name)->lists($name))
	              ->select('propertynumber')
	              ->get();
	return $itemprofile;
	}

	/**
	*
	*	@return query for unassembled item 	
	*
	*/
	public function scopeUnassembled($query)
	{
		return $query->whereNotIn('id',Pc::lists('systemunit_id'))
					->whereNotIn('id',Pc::lists('monitor_id'))
					->whereNotIn('id',Pc::lists('keyboard_id'))
					->whereNotIn('id',Pc::lists('avr_id'));
	}

	/**
	*
	*	@param itemprofile id
	*	@return itemprofile information
	*
	*/
	public static function setItemStatus($id,$status)
	{
		$itemprofile = ItemProfile::find($id);
		$itemprofile->status = $status;
		$itemprofile->save();
		return $itemprofile;
	}

	/**
	*
	*	@param item id
	*	@param room id
	*
	*/
	public static function setLocation($_item,$_room)
	{
		try
		{
			/*
			*	get the item profile
			*	assign to $item variable
			*/
			$item = Itemprofile::find($_item->id);

			/*
			*	set item location
			*	location is the room name
			*/
			$item->location  = $_room;

			/*
			*	get the room information
			*	link room and item
			*/
			$room = Room::location($_room)->first();
			$item->room()->sync([$room->id]);

			/*
			*
			*	create a transfer ticket
			*
			*/
			$details = "Items location has been set to $_room";
			$staffassigned = Auth::user()->id;
			$author = Auth::user()->firstname . " " . Auth::user()->middlename . " " . Auth::user()->lastname;
			Ticket::generateEquipmentTicket(
						$item->id,
						'Transfer',
						'Set Item Location',
						$details,
						$author,
						$staffassigned,
						null,
						'Closed'
					);
			$item->save();

		} 
		catch(Exception $e)
		{

			/*
			*	if no room inventory found
			*	create room inventory
			*	room inventory links item and room
			*/
			RoomInventory::createRecord($room,$item->id);
		}
	}

}
