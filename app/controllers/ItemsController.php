<?php

use Carbon\Carbon;
class ItemsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		/*
		|--------------------------------------------------------------------------
		|
		| 	Checks if request is made through ajax
		|
		|--------------------------------------------------------------------------
		|
		*/
		if(Request::ajax())
		{

			/*
			|--------------------------------------------------------------------------
			|
			| 	input->id contains filter for item to display
			|
			|--------------------------------------------------------------------------
			|
			*/
			if(Input::has('id'))
			{

				/*
				|--------------------------------------------------------------------------
				|
				| 	get id and sanitize to prevent sql injection
				|
				|--------------------------------------------------------------------------
				|
				*/
				$id = $this->sanitizeString(Input::get('id'));

				/*
				|--------------------------------------------------------------------------
				|
				| 	if id contains nothing or 'all', return all items 
				|
				|--------------------------------------------------------------------------
				|
				*/
				if($id == 'All' || $id == '')
				{
					return json_encode([
						'data' => ItemProfile::with('inventory')
												->with('receipt')
												->get()
					]);			
				}
				else 
				{

					/*
					|--------------------------------------------------------------------------
					|
					| 	return specific details of id
					|
					|--------------------------------------------------------------------------
					|
					*/
					$itemtype_id = ItemType::type($id)->pluck('id');
					return json_encode([
						'data' => ItemProfile::where('inventory_id','=',Inventory::type($itemtype_id)->pluck('id'))
												->with('inventory')
												->with('receipt')
												->get()
					]);	
				}
			}

			/*
			|--------------------------------------------------------------------------
			|
			| 	display all items
			|
			|--------------------------------------------------------------------------
			|
			*/
			return json_encode([
				'data' => ItemProfile::with('inventory')
										->with('receipt')
										->get()
			]);	
		}

		/*
		|--------------------------------------------------------------------------
		|
		| 	display all items
		|	return view for all items profile
		|
		|--------------------------------------------------------------------------
		|
		*/
		$itemtype = Itemtype::all();
		return View::make('item.profile')
				->with('itemtype',$itemtype);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		try {
			$id = $this->sanitizeString(Input::get('id'));
			$inventory = Inventory::find($id);
			return View::make('inventory.item.profile.create')
				->with('inventory',$inventory)
				->with('id',$id);

		} catch( Exception $e ) {
			return Redirect::to('inventory/item');
		}
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

		/*
		|--------------------------------------------------------------------------
		|
		| 	initialize items
		|
		|--------------------------------------------------------------------------
		|
		*/
		$inventory_id = $this->sanitizeString(Input::get('inventory_id'));
		$receipt_id = $this->sanitizeString(Input::get('receipt_id'));
		$location = $this->sanitizeString(Input::get('location'));
		$datereceived = $this->sanitizeString(Input::get('datereceived'));
		$propertynumber = "sample";
		$serialnumber = "sample";

		/*
		|--------------------------------------------------------------------------
		|
		| 	validates
		|
		|--------------------------------------------------------------------------
		|
		*/
		$validator = Validator::make([
				'Property Number' => $propertynumber,
				'Serial Number' => $serialnumber,
				'Location' => $location,
				'Date Received' => $datereceived,
				'Status' => 'working',
				'Location' => 'Server'
			],Itemprofile::$rules);

		if($validator->fails())
		{
			return Redirect::to("item/profile/create?id=$inventory_id")
				->withInput()
				->withErrors($validator);
		}


		/*
		|--------------------------------------------------------------------------
		|
		| 	loops through each items
		|
		|--------------------------------------------------------------------------
		|
		*/
		foreach(Input::get('item') as $item)
		{
			$propertynumber = $this->sanitizeString($item['propertynumber']);
			$serialnumber = $this->sanitizeString($item['serialid']);
			ItemProfile::createRecord($propertynumber,$serialnumber,'Server',$datereceived,$inventory_id,$receipt_id);
		}

		Session::flash('success-message','Item profiled');
		return Redirect::to('inventory/item');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{

		/*
		|--------------------------------------------------------------------------
		|
		| 	Check if request is made through ajax
		|
		|--------------------------------------------------------------------------
		|
		*/
		if(Request::ajax())
		{

			/*
			|--------------------------------------------------------------------------
			|
			| 	return itemprofile based on inventory_id
			|
			|--------------------------------------------------------------------------
			|
			*/
		 	return json_encode([
				'data' => Itemprofile::with('inventory')
									->where('inventory_id','=',$id)
									->get()
			]);
		}


		/*
		|--------------------------------------------------------------------------
		|
		| 	to prevent sql injection, used a try catch
		|
		|--------------------------------------------------------------------------
		|
		*/
		try
		{

			/*
			|--------------------------------------------------------------------------
			|
			| 	return view for specific item profile
			|
			|--------------------------------------------------------------------------
			|
			*/
			$inventory = Inventory::find($id);
			return View::make('inventory.item.profile.index')
									->with('inventory',$inventory);
		} 
		catch (Exception $e) 
		{

			/*
			|--------------------------------------------------------------------------
			|
			| 	return to inventory tab
			|
			|--------------------------------------------------------------------------
			|
			*/
			return Redirect::to('inventory/item');
		}
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$item = Itemprofile::find($id);
		return View::make('inventory.item.profile.edit')
			->with('itemprofile',$item);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$receipt_id = $this->sanitizeString(Input::get('receipt_id'));
		$property_number = $this->sanitizeString(Input::get('propertyid'));
		$serial_number = $this->sanitizeString(Input::get('serialid'));
		$location = $this->sanitizeString(Input::get('location'));
		$datereceived = $this->sanitizeString(Input::get('datereceived'));

		//validator
		$validator = Validator::make([
				'Property Number' => $property_number,
				'Serial Number' => $serial_number,
				'Location' => $location,
				'Date Received' => $datereceived,
				'Status' => 'working',
				'Location' => 'Server'
			],ItemProfile::$updateRules);

		if($validator->fails())
		{
			return Redirect::back()
				->withInput()
				->withErrors($validator);
		}
		
		$itemprofile = Itemprofile::find($id);
		$itemprofile->propertynumber = $property_number;
		$itemprofile->serialnumber = $serial_number;
		$itemprofile->receipt_id = $receipt_id;
		$itemprofile->location = $location;
		$itemprofile->datereceived = Carbon::parse($datereceived);
		$itemprofile->save();

		Session::flash('success-message','Item updated');

		return Redirect::to('inventory/item');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		/*
		|--------------------------------------------------------------------------
		|
		| 	Checks if request is ajax or not
		|
		|--------------------------------------------------------------------------
		|
		*/
		if(Request::ajax()){

			/**
			*
			*	Try catch to prevent injection
			*
			*/
			try{

				/**
				*
				*	@param id
				*	@return collection
				*
				*/
				$itemprofile = ItemProfile::find($id);

				/*
				|--------------------------------------------------------------------------
				|
				| 	Checks if itemprofile is linked to a pc
				|	return 'connected' if linked
				|
				|--------------------------------------------------------------------------
				|
				*/
				if(count(Pc::isPc($itemprofile->propertynumber)) > 0)
				{
					return json_encode('connected');

				}

				/**
				*
				*	Call function condemn
				*
				*/
				Inventory::condemn($id);
				return json_encode('success');
			} catch ( Exception $e ) {}
		}

		Inventory::condemn($item->inventory_id);
		Session::flash('success-message','Item removed from inventory');
		return Redirect::to('inventory/item');
	}

	/**
	*
	*	Display the ticket
	*	@param $id accepts id of item
	*	@return view
	*
	*/
	public function history($id)
	{

		/**
		*
		*	@param id
		*	@return ticket information
		*	@return inventory
		*	@return itemtype
		*
		*/
		$itemprofile = ItemProfile::with('itemticket.ticket')->with('inventory.itemtype')->find($id);	
		return View::make('item.history')
				->with('itemprofile',$itemprofile); 
	}

	/**
	*
	*	uses get method
	*	@param $item accepts item id
	*	@param $room accepts room name	
	*	@return error or page
	*
	*/
	public function assign()
	{
		$item = $this->sanitizeString(Input::get('item'));
		$room = $this->sanitizeString(Input::get('room'));
		$room = Room::location($room)->select('id','name')->first();

		/*
		|--------------------------------------------------------------------------
		|
		| 	Validates input
		|
		|--------------------------------------------------------------------------
		|
		*/
		$validator = Validator::make([
			'Item' => $item,
			'Room' => $room->id
		],RoomInventory::$rules);

		if($validator->fails())
		{
			Session::flash('error-message','Error occurred while processing your data');
			return Redirect::to('inventory/item');
		}

		/*
		|--------------------------------------------------------------------------
		|
		| 	Check if connected to a pc
		|
		|--------------------------------------------------------------------------
		|
		*/
		$itemprofile = Itemprofile::find($item);
		if(count(Pc::isPc($itemprofile->propertynumber)) > 0)
		{
			Session::flash('error-message','This item is used in a workstation. You cannot remove it here. You need to proceed to workstation');
			return Redirect::to('inventory/item');

		}

		/*
		|--------------------------------------------------------------------------
		|
		| 	Save
		|	1 - If existing update
		|	2 - If not create new record
		|
		|--------------------------------------------------------------------------
		|
		*/
		try
		{		
			$itemprofile->location = $room->name;
			$itemprofile->save();
			$itemprofile->room()->sync([ 'room_id'=>$room->id ]);
		} catch (Exception $e)  {
			$roominventory = new RoomInventory;
			$roominventory->room_id = $room->id;
			$roominventory->item_id = $item;
			$roominventory->save();
		}

		Session::flash('success-message',"Item assigned to room $room->name");
		return Redirect::back();
	}

}
