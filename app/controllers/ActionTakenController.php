<?php

class ActionTakenController extends \BaseController {

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$tickets = Ticket::where('type','=','complaint')
				->orWhere('type','=','incident')
				->has('actiontaken','=',0)
				->get();
		return View::make('ticket.actiontaken.create')
			->with('incidents',$tickets);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$incident = $this->sanitizeString(Input::get('incident'));
		$description = $this->sanitizeString(Input::get('description'));

		$validator = Validator::make([
				'details' => $description,
				'incident' => $incident
			],ActionTaken::$rules);

		if($validator->fails())
		{
			return Redirect::back()
				->withErrors($validator)
				->withInput();
		}

		$actiontaken = new ActionTaken;
		$actiontaken->generateActionTaken($incident,$description);

		Session::flash('success-message','Ticket Generated');
		return Redirect::to('ticket/actiontaken');
	}

	public function show($id)
	{
		$item = Ticket::find($id);
		return View::make('ticket.actiontaken.show')
			->with('item',$item);
	}

}
