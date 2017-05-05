<?php

class OthersTicketController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('ticket.others.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$title = $this->sanitizeString(Input::get('title'));
		$description = $this->sanitizeString(Input::get('description'));

		$validator = Validator::make([
			'Title' => $title,
			'Details' => $description,
			'Type' => 'others'
		],Ticket::$rules);

		if($validator->fails())
		{
			return Redirect::to('ticket/others')
				->withInput()
				->withErrors($validator);
		}

		$ticket = new Ticket;
		$ticket->generateOthersTicket($title,$description);

		Session::flash('success-message','Ticket generated');
		return Redirect::to('ticket/others');
	}


}
