<?php

class RoomLogController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('room.log.index')
			->with('rooms',Room::all());
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('room.log.create')
			->with('rooms',Room::all());
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$name = $this->sanitizeString(Input::get('name'));
		$room = $this->sanitizeString(Input::get('room'));
		$section = $this->sanitizeString(Input::get('section'));
		$units = $this->sanitizeString(Input::get('units'));
		$timestart = Carbon\Carbon::parse($this->sanitizeString(Input::get('time_start')));
		$timeend = Carbon\Carbon::parse($this->sanitizeString(Input::get('time_end')));

		$validator = Validator::make([
				'time start' => $timestart,
				'time end' => $timeend,
				'room name' => $room,
				'section' => $section,
				'number of working units' => $units,
				'faculty-in-charge' => $name 
			],Roomlog::$rules);

		if($validator->fails())
		{
			return Redirect::back()
				->withInput()
				->withErrors($validator);
		}

		$roomlog = new Roomlog;
		$roomlog->facultyincharge = $name;
		$roomlog->room_id = $room;
		$roomlog->timein = $timestart;
		$roomlog->timeout = $timeend;
		$roomlog->workingunits = $units;
		$roomlog->section = $section;
		$roomlog->staffincharge = Auth::user()->username;
		$roomlog->save();

		Session::flash('success-message','Log created');
		return Redirect::to('dashboard');
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
