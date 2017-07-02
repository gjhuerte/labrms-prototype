<?php

class RoomInventoryAssignmentController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('inventory.room.assign.index');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$item = $this->sanitizeString(Input::get('propertynumber'));
		$room = $this->sanitizeString(Input::get('room'));

		$item = Itemprofile::where('propertynumber','=',$item)->select('id')->first();
		$validator = Validator::make([
			'Item' => $item->id,
			'Room' => $room
		],Roominventory::$rules);

		if($validator->fails())
		{
			return Redirect::to('inventory/room/assign')
				->withInput()
				->withErrors($validator);
		}

		$rooms = Room::find($room);
		
		$itemprofile = Itemprofile::find($item->id);
		$itemprofile->location = $rooms->name;
		$itemprofile->save();

		$roominventory = new Roominventory;
		$roominventory->item_id = $item->id;
		$roominventory->room_id = $room;
		$roominventory->save();

		Session::flash('success-message','Item deployed');
		return Redirect::to('inventory/room');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
