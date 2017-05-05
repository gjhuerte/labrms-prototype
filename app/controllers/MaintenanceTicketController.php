<?php

class MaintenanceTicketController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$inventory = Inventory::all();	
		return View::make('ticket.maintenance.create')
			->with('inventory',$inventory);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

		$property_number = $this->sanitizeString(Input::get('property_number'));
		$title = $this->sanitizeString(Input::get('title'));
		$description = $this->sanitizeString(Input::get('description'));
		$clientname = $this->sanitizeString(Auth::user()->username);

		$validator = Validator::make([
			'Title' => $title,
			'Details' => $description,
			'Type' => 'incident'
		],Ticket::$rules);

		if($validator->fails())
		{
			return Redirect::back()
				->withInput()
				->withErrors($validator);
		}
		
		$ticket = new Ticket;
		if($ticket->generateMaintenanceTicket($title,$description,$clientname,$property_number)){
		
			Session::flash('success-message','Ticket generated');
			return Redirect::to('ticket/maintenance');
		}else{
			return Redirect::back()
				->withInput()
				->withErrors('Invalid Property Number');
		}
	}


}
