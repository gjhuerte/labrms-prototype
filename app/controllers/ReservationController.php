<?php

use Carbon\Carbon;

class ReservationController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$reservation = Reservation::all();
		return View::make('reservation.approval.index')
			->with('reservationdetails',$reservation);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$reservations = Reservation::where('dateofuse','>=',Carbon::now()->toDateString())->paginate(8);
		$purpose = [
			'Oral Defense / Presentation' => 'Oral Defense / Presentation',
			'General Assembly' => 'General Assembly',
			'Seminar' => 'Seminar',
			'Tutorial' => 'Tutorial',
			'Make-up Class' => 'Make-up Class',
			'Class Presentation' => 'Class Presentation',
			'Class Activity' => 'Class Activity',
			'Others' => 'Others'
		];

		$room = Room::lists('name','name');
		$itemtype = Itemtype::where('type','!=','System Unit')
			->where('type','!=','AVR')
			->where('type','!=','Extension')
			->where('type','!=','Aircon')
			->where('type','!=','Display')
			->lists('type','type');	
		return View::make('reservation.create')
			->with('room',compact('room','room'))
			->with('purpose',compact('purpose','purpose'))
			->with('itemtype',compact('itemtype','itemtype'))
			->with('date',Carbon::now()->addDays(3)->toDateString())
			->with('reservations',$reservations);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$dateofuse = Carbon::parse($this->sanitizeString(Input::get('dateofuse')));
		$dateofuse = (empty($dateofuse)) ? "" : $dateofuse ;
		$timein = Carbon::parse(Input::get('time_start'));
		$timein = (empty($timein)) ? "" : $timein;
		$timeout = Carbon::parse($this->sanitizeString(Input::get('time_end')));
		$timeout = (empty($timeout)) ? "" : $timeout ;
		$property_number = $this->sanitizeString(Input::get('property_number'));
		$purpose = $this->sanitizeString(Input::get('purpose'));
		$name = $this->sanitizeString(Input::get('name'));
		$borrower = $this->sanitizeString(Auth::user()->id);
		$location = $this->sanitizeString(Input::get('location'));

		if($dateofuse->isSameDay(Carbon::now()))
		{
			$message = "Cannot reserve on the same day";
			Session::flash('error-message',$message);
			return Redirect::back()
				->withInput();
		}	

		if($dateofuse < Carbon::now()->toDateString())
		{
			Session::flash('error-message',"Cannot reserve past date");
			return Redirect::back()
				->withInput();				
		}
		//check if start is greater than end time
		if($timein->diffInMinutes($timeout, false) <= 0)
		{
			Session::flash('error-message',"Start time must be less than end time");
			return Redirect::back()
				->withInput();

		}
		//if the date is already reserved
		$reservation = new Reservation;
		$result = $reservation->hasReserved($property_number,$timein,$timeout,$dateofuse);
		if($result != false)
		{
			$message = "Time already reserved from ".Carbon::parse($result->timein)->format('h:i:s A')." to ".Carbon::parse($result->timeout)->format('h:i:s A').".";
			Session::flash('error-message',$message);
			return Redirect::back()
				->withInput();
		}
		//validator
		$validator = Validator::make([
				'item name' => $property_number,
				'purpose' => $purpose,
				'faculty-in-charge' => $name,
				'location' => $location,
				'date of use' => $dateofuse,
				'time started' => $timein,
				'time end' => $timeout
				],Reservation::$rules);

		if($validator->fails())
		{
			return Redirect::back()
				->withInput()
				->withErrors($validator);
		}

		if(Auth::user()->accesslevel == 0)
			$approval = '1';
		else
			$approval = '0';
		$reservation = [
			'purpose' => $purpose,
			'facultyincharge' => $name,
			'location' => $location,
			'dateofuse'=> $dateofuse,
			'timein' => $timein,
			'timeout' => $timeout,
			'approval' => $approval
		];

		$user = User::find(Auth::user()->id);
		$itemprofile = Itemprofile::find($property_number);
		$user->itemprofile()->attach($itemprofile,$reservation);

		Session::flash('success-message','Reservation requested. Visit your home tab to check for approval');
		return Redirect::to('reservation');
	}

	public function show($id)
	{
		$reservation = Reservation::find($id);
		return View::make('reservation.show')
			->with('reservation',$reservation);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$reservation = Reservation::find($id);
		
		if(Input::get('approve') == 'Approve')
		{
			$reservation->approval = '1';
			$reservation->save();	

			Session::flash('success-message','Reservation approved');
		}elseif(Input::get('disapprove') == 'Disapprove')
		{
			$reservation->approval = '2';
			$reservation->save();

			Session::flash('success-message','Reservation disapproved');
		}

		return Redirect::back();
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$reservation = Reservation::find($id);
		$reservation->delete();

		Session::flash('success-message','Reservation information cancelled');
		return Redirect::to('dashboard');
	}

	
	public function getItemList()
	{
		if(Request::ajax())
		{
			$itemprofile = Itemprofile::whereHas('inventory', function($query)
			{
			    $query->where('itemname', '=', $this->sanitizeString(Input::get('itemname')));

			})->get();
			return json_encode($itemprofile);
		}
	}

	public function getItemName()
	{
		if(Request::ajax())
		{
			$inventory = Inventory::leftJoin('itemprofile','inventory_id','=','inventory.id')
				->where('type','=',$this->sanitizeString(Input::get('itemtype')))
				->groupBy('itemname')->get();
			return json_encode($inventory);
		}
	}


}
 