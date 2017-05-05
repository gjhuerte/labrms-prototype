<?php

class ItemsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$inventory = Inventory::all();
		return View::make('item.index')
			->with('inventorydetails',$inventory);
	} 


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('item.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{	
		$itemname = $this->sanitizeString(Input::get('itemname'));
		$serialid = $this->sanitizeString(Input::get('serialid'));
		$property_number = $this->sanitizeString(Input::get('propertyid'));
		$MR_no = $this->sanitizeString(Input::get('MR_no'));
		$description = $this->sanitizeString(Input::get('description'));

		//validator
		$validator = Validator::make([
				'name' => $itemname,
				'serial id' => $serialid,
				'property number' => $property_number,
				'MR number' => $MR_no,
				'description' => $description,
				'status' => 'working',
				'location' => 'Server'
			],Itemprofile::$rules);

		if($validator->fails())
		{
			return Redirect::to('item/profile/create')
				->withInput()
				->withErrors($validator);
		}else
		{
			$inventory = Inventory::where('itemname','=',$itemname)->first();
			if(empty($inventory))
			{
				$inventory = Inventory::create([
						'itemname' => Input::get('itemname'),
						'quantity' => '0',
						'added' => '0',
						'adjust' => '0',
						'deduct' => '0',
						'total' => '0'
					]);
			}

			$item = new Itemprofile;
			$item->serialid = Input::get('serialid');
			$item->property_number = Input::get('propertyid');
			$item->type = Input::get('type');
			$item->MR_no = Input::get('MR_no');
			$item->description = '"'.Input::get('description').'"';
			$item->status = 'working';
			$item->location = 'Server';
			$item->inventory()->associate($inventory);
			$item->save();

			$inventory->increaseInventoryQuantity($inventory->id);
				
			$ticket = new Ticket;
			$item = Itemprofile::where('property_number','=',$property_number)->first();
			$ticket->generateReceiveTicket($description,$item->id);

			Session::flash('success-message','Item added to inventory');

			return Redirect::to('inventory/item');

		}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$item = Itemprofile::find($id);
		return View::make('item.show')
			->with('item',$item);
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
		if( Input::get('transfer') == 'Transfer' )
		{
			return View::make('item.transfer')
				->with('item',$item);
		}else{

			return View::make('item.update')
				->with('item',$item);
		}
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		if(Input::get('transfer') == 'Transfer')
		{
			$newlocation = $this->sanitizeString(Input::get('newlocation'));
			$itemprofile = Itemprofile::find($id);
			$itemprofile->location = $newlocation;
			$itemprofile->save();

			//create a ticket
			$ticket = Ticket::create([
				'title' => 'Transfer/Deployment',
				'description' => 'Item deployed to room '.$newlocation,
				'type' => 'others',
				'clientname' => Auth::user()->username
			]); 

			$ticket = Ticket::find($ticket->id);
			$itemprofile = Itemprofile::find($id);
			$ticket->itemprofile()->associate($itemprofile);
			$ticket->save();

			Session::flash('success-message','Item transferred');
			return Redirect::to('inventory/item');

		}else
		{
			//validator
			$validator = Validator::make([
				'serial id' => Input::get('serialid'),
				'property number' => Input::get('propertyid'),
				'MR number' => Input::get('MR_no'),
				'description' => 'sample',
				'status' => 'working',
				'location' => 'Server'
			],Itemprofile::$updateRules);

			if($validator->fails())
			{
				return Redirect::to("item/profile/{$id}/edit")
					->withInput()
					->withErrors($validator);
			}else
			{
				$itemname = $this->sanitizeString(Input::get('itemname'));
				$serialid = $this->sanitizeString(Input::get('serialid'));
				$property_number = $this->sanitizeString(Input::get('propertyid'));
				$MR_no = $this->sanitizeString(Input::get('MR_no'));
				$description = $this->sanitizeString(Input::get('description'));
				$type = $this->sanitizeString(Input::get('type'));

				//validator
				$validator = Validator::make([
						'name' => $itemname,
						'serialid' => $serialid,
						'property number' => $property_number,
						'MR number' => $MR_no,
						'description' => $description,
						'status' => 'working',
						'location' => 'Server'
					],Itemprofile::$updateRules);

				$itemprofile = Itemprofile::find($id);
				$itemprofile->serialid = $serialid;
				$itemprofile->property_number = $property_number;
				$itemprofile->type = $type;
				$itemprofile->MR_no = $MR_no;
				$itemprofile->save();

				//create a ticket
				$ticket = Ticket::create([
					'title' => 'Update Item profile',
					'description' => 'Item information update',
					'type' => 'others',
					'clientname' => Auth::user()->username
				]); 

				$ticket = Ticket::find($ticket->id);
				$itemprofile = Itemprofile::find($id);
				$ticket->itemprofile()->associate($itemprofile);
				$ticket->save();

				Session::flash('success-message','Item information updated');

				return Redirect::to('inventory/item');

			}
		}
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{			
		$item = Itemprofile::find($id);
		$item->status = "condemn";

		$inventory =  Inventory::find($item->inventory_id);
		$inventory->decreaseInventoryQuantity($item->inventory_id);
		//create a ticket
		$ticket = Ticket::create([
			'title' => 'Condemn items',
			'description' => "Item with property number ".$item->property_number." sent to property office for disposal",
			'type' => 'condemn',
			'clientname' => Auth::user()->username
		]); 

		$ticket = Ticket::find($ticket->id);
		$itemprofile = Itemprofile::find($item->id);
		$ticket->itemprofile()->associate($itemprofile);
		//transact
		$ticket->save();
		$inventory->save();
		$item->save();
		$item = Itemprofile::find($id);
		$item->delete();

		Session::flash('success-message','Item removed from inventory');

		return Redirect::to('item/profile');
	}


}
