<?php

class RoomInventoryController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('inventory.room.index')
			->with('rooms',Room::all())
			->with('active_tab','room');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$workstations = Pc::all();
		return View::make('inventory.room.create')
			->with('workstations',$workstations);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{		
		$pc = Pc::find($id);
		return View::make('workstation.show')
			->with('pc',$pc);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$roominventory = Roominventory::where('room_id','=',$id)->get();
		return View::make('inventory.room.update')
			->with('roominventory',$roominventory);
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
			$item = $this->sanitizeString(Input::get('item'));
			$room = $this->sanitizeString(Input::get('room'));

			$validator = Validator::make([
					'item' => $item,
					'room' => $room
				],Roominventory::$rules);

			if($validator->fails())
			{
				return Redirect::back()
					->withInput()
					->withErrors($validator);
			}

			$roominfo = Room::where('name','=',$room)->first();
			$item = Pc::where('name','=',$item)->first();
			$roominventory = Roominventory::where('room_id','=',$roominfo->id)->first();
			$roominventory->item_id = $item->id;
			$roominventory->room_id = $room;
			$roominventory->save();

			Session::flash('success-message','Workstation deployed');
			return Redirect::to('inventory/room');
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
		$roominventory = Roominventory::where('item_id','=',$id)->first();
		$roominventory->delete();
		$pc = Pc::find($id);
		$inventory = new Inventory;
		$itemprofile = new Itemprofile;
		$inventory->decreaseInventoryQuantity($pc->systemunit->inventory->id);
		$itemprofile->setItemAsCondemned($pc->systemunit->inventory->id);
		$itemprofile->setItemAsCondemned($pc->display->inventory->id);
		$inventory->decreaseInventoryQuantity($pc->display->inventory->id);

		$item = Itemprofile::find($pc->systemunit->id);
		$ticket = new Ticket;
		$ticket->generateCondemnTicket($item->property_number,$item);
		$item->status = "condemn";
		$item->save();

		$item = Itemprofile::find($pc->systemunit->id);
		$item->delete();


		$item = Itemprofile::find($pc->display->id);
		$ticket = new Ticket;
		$ticket->generateCondemnTicket($item->property_number,$item);
		$item->status = "condemn";
		$item->save();



		$item = Itemprofile::find($pc->display->id);
		$item->delete();

		$pc = Pc::find($id);
		$pc->delete();
		$item = Itemprofile::find($id);

		Session::flash('success-message','Workstation condemned');
		return Redirect::to('workstation');
	}


}
