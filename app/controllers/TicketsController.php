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
										->where('status','=','Open')
										->orderBy('created_at', 'desc')
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
		$ticket = Ticket::orderBy('created_at', 'desc')->first();

		if (count($ticket) == 0 ) {
			$ticket = 1;
		} else if ( count($ticket) > 0 ) {
			$ticket = $ticket->id + 1;
		}

		return View::make('ticket.create')
				->with('lastticket',$ticket);
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

		($type == 'maintenance') ? $maintenancetype = 'maintenance type:'. $maintenancetype . ',details:' : $maintenancetype = "";

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
		$ticket->ticketname = ($type == 'maintenance') ? $category : $type;
		$ticket->tickettype = $type;
		$ticket->details = $maintenancetype . $details;
		$ticket->author = $author;
		$ticket->staffassigned = $staffassigned;
		$ticket->status = 'Open';
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
		$ticket = Ticket::find($id);
		return View::make('ticket.edit')
				->with('ticket',$ticket);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$propertynumber = $this->sanitizeString(Input::get('propertynumber'));
		$type = $this->sanitizeString(Input::get('type'));
		$maintenancetype = $this->sanitizeString(Input::get('maintenancetype'));
		$category = $this->sanitizeString(Input::get('category'));
		$author = $this->sanitizeString(Input::get('author'));
		$details = $this->sanitizeString(Input::get('description'));
		$staffassigned = Auth::user()->id;
		$propertynumber;

		($type == 'maintenance') ? $maintenancetype = 'maintenance type:'. $maintenancetype . ',details:' : $maintenancetype = "";
		try{
			$item = Itemprofile::where('propertynumber','=',trim($propertynumber))->first();
			if(count($item) == 0)
			{
				return Redirect::to("ticket/$id/edit")
						->withInput()
						->withErrors([ 'Invalid Property Number' ]);
			}

			$propertynumber = $item->id;
		} catch ( Exception $e ) {
			return Redirect::to("ticket/$id/edit")
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
			return Redirect::to("ticket/$id/edit")
				->withInput()
				->withErrors($validator);
		}

		try{

			$ticket = Ticket::find($id);
			$ticket->item_id = $propertynumber;
			$ticket->ticketname = $category;
			$ticket->tickettype = $type;
			$ticket->details = $maintenancetype . $details;
			$ticket->author = $author;
			$ticket->save();
		} catch (Exception $e) {
				Session::flash('error-message','Error occured while processiong your data');
				return Redirect::to("ticket/$id/edit")
					->withInput();
		}

		Session::flash('success-message','Ticket Generated');
		return Redirect::to('ticket');

	}

	public function transfer($id)
	{
		$id = $this->sanitizeString(Input::get('id'));
		$staffassigned = $this->sanitizeString(Input::get('transferto'));

		try{
			$_ticket = Ticket::find($id);

			$ticket = new Ticket;
			$ticket->item_id = $_ticket->item_id;
			$ticket->ticketname = $_ticket->f;
			$ticket->tickettype = $_ticket->tickettype;
			$ticket->details = $_ticket->details;
			$ticket->author = $_ticket->author;
			$ticket->staffassigned = $staffassigned;
			$ticket->status = $_ticket->status;
			$ticket->ticket_id = $_ticket->id;
			$ticket->save();

			$_ticket->status = "Transferred";
			$_ticket->save();
		} catch ( Exception $e ) {

			Session::flash('error-message','Problem encountered while processing your request');
			return Redirect::to('ticket');

		}

		Session::flash('success-message','Ticket Transferred');
		return Redirect::to('ticket');
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
				$ticket->status = 'Closed';
				$ticket->save();
				$ticket->delete();
				return json_encode('success');
			} catch ( Exception $e ) {
				return json_encode('error');
			}
		}
	}

	public function showHistory($id)
	{		
		if(Request::ajax())
		{
			$arraylist = array();
			$cond = true;
			$ticket;	

			do{	

				$ticket =  Ticket::where('id','=',$id)
							->with('user')
							->first();

				try {
					$id = $ticket->ticket_id;
					array_push($arraylist,$ticket);
				} catch( Exception $e ) { 
					$cond = false;
				}


			} while ( $cond == true);

			return json_encode($arraylist);
		}

		try{
			$ticket = Ticket::with('itemprofile')
								->where('id','=',$id)
								->first();
			return View::make('ticket.history')
				->with('ticket',$ticket)
				->with('id',$id);
		} catch ( Exception $e ) {

			Session::flash('error-message','Problem encountered while processing your request');
			return Redirect::to('ticket');

		}
	}

	public function resolve($id)
	{
		if(Request::ajax())
		{
			try{

				$id = $this->sanitizeString(Input::get('id'));
				$details = $this->sanitizeString(Input::get('details'));

				try{
					$_ticket = Ticket::find($id);

					$ticket = new Ticket;
					$ticket->item_id = $_ticket->item_id;
					$ticket->ticketname = 'action taken';
					$ticket->tickettype = 'action taken';
					$ticket->details = $details;
					$ticket->author = Auth::user()->firstname . " " . Auth::user()->lastname;
					$ticket->staffassigned = Auth::user()->id;
					$ticket->status = 'Open';
					$ticket->ticket_id = $_ticket->id;
					$ticket->save();

					$_ticket->status = 'Closed';
					$_ticket->save();

					return json_encode('success');
				} catch ( Exception $e ) {}
			} catch (Exception $e) {}

		}
	}

	public function complaint()
	{
		return Redirect::to('ticket/complaint');
	}

	public function complaintViewForStudentAndFaculty()
	{
		if(Request::ajax())
		{
			return json_encode([
					'data' => Ticket::with('itemprofile')
										->with('user')
										->where('status','=','Open')
										->get()
				]);
		}
		return View::make('ticket.complaint');
	}

}
