<?php

use Carbon\Carbon;
class LendController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{

		$room = Room::lists('name','name');
		$itemtype = Itemtype::where('type','=','Extension')
					->orWhere('type','=','Projector')
					->orWhere('type','=','TV')
					->lists('type','type');	
		return View::make('lend.create')
			->with('room',compact('room','room'))
			->with('itemtype',compact('itemtype','itemtype'))
			->with('date',Carbon::now()->addDays(3)->toDateString());
	}

	public function approve()
	{
		return View::make('lend.approval')
			->with('lend',Lendlog::all())
			->with('active_tab','lend');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$property_number = $this->sanitizeString(Input::get('property_number'));
		$name = $this->sanitizeString(Input::get('name'));
		$location = $this->sanitizeString(Input::get('location'));

		$validator = Validator::make([
				'property number' =>  $property_number,
				'faculty-in-charge' => $name,
				'location' => $location 
			],Lendlog::$rules);

		if($validator->fails())
		{
			return Redirect::back()
				->withInput()
				->withErrors($validator);
		}

		$itemprofile = Itemprofile::where('property_number','=',$property_number)->first();
		Lendlog::create([
				'item_id' => $itemprofile->id,
				'clientname' => Auth::user()->username,
				'facultyincharge' => $name,
				'date' => Carbon\Carbon::now()->toDateString(),
				'timein' => Carbon\Carbon::now()->toTimeString()
			]);

		Session::flash('success-message','Item borrowed successfully logged');
		return Redirect::to('borrow');
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

		$lendlog = Lendlog::find($id);
		$lendlog->timeout = Carbon\Carbon::now()->toTimeString();
		$lendlog->save();
		Session::flash('success-message','Item return successfully logged');
		return Redirect::to('lend');
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
