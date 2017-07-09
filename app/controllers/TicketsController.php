<?php

class TicketsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if(Request::ajax())
		{
			return json_encode([
					'data' => Ticket::with('itemprofile')
										->with('user')
										->get()
				]);
		}
		return View::make('ticket.index');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('ticket.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$item = $this->sanitizeString(Input::get('propertynumber'));
		$type = $this->sanitizeString(Input::get('type'));
		$maintenancetype = $this->sanitizeString(Input::get('maintenancetype'));
		$category = $this->sanitizeString(Input::get('category'));
		$author = $this->sanitizeString(Input::get('author'));
		$details = $this->sanitizeString(Input::get('description'));
		$staffassigned = Auth::user()->id;
		$propertynumber;

		try{
			$item = Itemprofile::where('propertynumber','=',$item)->first();
			$propertynumber = $item->id;
		} catch ( Exception $e ) {
			return Redirect::to('ticket/create')
					->withInput()
					->withErrors([ 'Invalid Property Number' ]);
		} 

		$validator = Validator::make([
				'Item Id' => $propertynumber,
				'Ticket Type' => $category,
				'Ticket Name' => $type,
				'Details' => $details,
				'Author' => $author,
			],Ticket::$rules);

		if($validator->fails())
		{
			return Redirect::to('ticket/create')
				->withInput()
				->withErrors($validator);
		}

		$ticket = new Ticket;
		$ticket->item_id = $propertynumber;
		$ticket->ticketname = $category;
		$ticket->tickettype = $type;
		$ticket->details = $details;
		$ticket->author = $author;
		$ticket->staffassigned = $staffassigned;
		$ticket->status = 0;
		$ticket->save();

		Session::flash('success-message','Ticket Generated');
		return Redirect::to('ticket');

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
		if(Request::ajax())
		{
			try{

				$ticket = Ticket::find($id);
				$ticket->status = 1;
				$ticket->save();
				$ticket->delete();
				return json_encode('success');
			} catch ( Exception $e ) {
				return json_encode('error');
			}
		}
	}


}
