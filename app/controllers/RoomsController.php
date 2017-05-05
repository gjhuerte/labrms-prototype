<?php

class RoomsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$rooms = Room::all();
		return View::make('room.index')
			->with('rooms',$rooms);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('room.create');
	}

	public function getAllItems()
	{
		if(Request::ajax())
		{
			$inventory = Inventory::where('itemname','=',Input::get('item'))->first();
			$itemprofile = Itemprofile::where('location','=',Input::get("room"))
				->where('inventory_id','=',$inventory->id)
				->where('status','!=','condemn')
				->get();
			return json_encode($itemprofile);
		}
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if(Input::get('cancel') == 'Cancel')
		{
			return Redirect::to('room');
		}

		if(Input::get('create') == 'Create')
		{
			$data = [
				'name' => Input::get('name'),
				'description' => Input::get('description')
			];

			$validator = Validator::make($data,Room::$rules);

			if($validator->fails())
			{
				return Redirect::to('room/create')
					->withInput()
					->withErrors($validator);
			}

			$room = new Room;
			$room->name = Input::get('name');
			$room->description = Input::get('description');
			$room->save();

			Session::flash('success-message','Room information created!');
			return Redirect::to('room');
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
		$room = Room::find($id);
		return View::make('room.update')
			->with('room',$room);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		if(Input::get('cancel') == 'Cancel')
		{
			return Redirect::to('room');
		}

		if(Input::get('create') == 'Update')
		{
			$data = [
				'name' => Input::get('name'),
				'description' => Input::get('description')
			];

			$validator = Validator::make($data,Room::$updateRules);

			if($validator->fails())
			{
				return Redirect::to("room/$id/edit")
					->withInput()
					->withErrors($validator);
			}

			$room = Room::findOrFail($id);
			$room->name = Input::get('name');
			$room->description = Input::get('description');
			$room->save();

			Session::flash('success-message','Room information updated!');
			return Redirect::to('room');
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
		$room = Room::findOrFail($id);
		$room->delete();
		Session::flash('success-message','Room information deleted');
		return Redirect::to('room');
	}


}
