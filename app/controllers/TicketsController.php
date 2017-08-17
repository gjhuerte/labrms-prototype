<?php

class TicketsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		/*
		|--------------------------------------------------------------------------
		|
		| 	Check if request is made through ajax
		|
		|--------------------------------------------------------------------------
		|
		*/
		if(Request::ajax())
		{

			/*
			|--------------------------------------------------------------------------
			|
			| 	Administrator and Laboratory Assistant
			|
			|--------------------------------------------------------------------------
			|
			*/
			if( Auth::user()->accesslevel == 0 || Auth::user()->accesslevel == 1 )
			{

				if(Input::has('type'))
				{
					$type = $this->sanitizeString(Input::get('type'));
				}

				if(Input::has('assigned'))
				{
					$assigned = $this->sanitizeString(Input::get('assigned'));
				}

				if(Input::has('status'))
				{
					$status = $this->sanitizeString(Input::get('status'));
				}

				return json_encode([ 
					'data' => TicketView::tickettype($type)->status($status)->get()
			 	]);
			}

			/*
			|--------------------------------------------------------------------------
			|
			| 	Laboratory Staff 
			|
			|--------------------------------------------------------------------------
			|
			*/
			if( Auth::user()->accesslevel == 2 )
			{
				return json_encode([ 
					'data' => TicketView::where('staff_id','=',Auth::user()->id)
								->get()
			 	]);
			}
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

		if (count($ticket) == 0 ) 
		{
			$ticket = 1;
		} 
		else if ( count($ticket) > 0 ) 
		{
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
		$tag = $this->sanitizeString(Input::get('tag'));
		$ticketname = "";	

		/*
		|--------------------------------------------------------------------------
		|
		| 	Verifies if the user inputs  a title
		|
		|--------------------------------------------------------------------------
		|
		*/
		if(Input::has('title'))
		{
			$ticketname = $this->sanitizeString(Input::get('title'));

			/*
			|--------------------------------------------------------------------------
			|
			| 	Check if ticketname has no value
			|	if no value, type will be automatically complaint
			|
			|--------------------------------------------------------------------------
			|
			*/
			if($ticketname == '' || $ticketname == null)
			{
				$ticketname = 'complaint';
			} 
		}
		else
		{
			$ticketname = 'complaint';
		}
	
		/*
		|--------------------------------------------------------------------------
		|
		| 	Verifies if the user inputs an author
		|
		|--------------------------------------------------------------------------
		|
		*/
		if(Input::has('author'))
		{
			$author = $this->sanitizeString(Input::get('author'));
		}	
		else
		{
			$author = Auth::user()->firstname . " " . Auth::user()->middlename . " " .Auth::user()->lastname;
		}

		$details = $this->sanitizeString(Input::get('description'));
		$staffassigned = Auth::user()->id;
		$status = 'Open';
		$ticket_id = null;

		$validator = Validator::make([
				'Ticket Title' => $ticketname,
				'Details' => $details,
				'Author' => $author,
			],Ticket::$complaintRules);

		if($validator->fails())
		{
			return Redirect::to('ticket/create')
				->withInput()
				->withErrors($validator);
		}
	

		/*
		|--------------------------------------------------------------------------
		|
		| 	Check if the tag is equipment
		|
		|--------------------------------------------------------------------------
		|
		*/
		$itemprofile = ItemProfile::propertyNumber($tag)->first();
		if( count($itemprofile) > 0)
		{

			/*
			|--------------------------------------------------------------------------
			|
			| 	Check if the equipment is connected to pc
			|
			|--------------------------------------------------------------------------
			|
			*/
			$pc = Pc::isPc($tag);
			if(count($pc) > 0)
			{
				Ticket::generatePcTicket($pc->id,'complaint',$ticketname,$details,$author,$staffassigned,$ticket_id,$status);
			} 
			else
			{

				/*
				|--------------------------------------------------------------------------
				|
				| 	Create equipment ticket
				|
				|--------------------------------------------------------------------------
				|
				*/
				Ticket::generateEquipmentTicket($itemprofile->id,'complaint',$ticketname,$details,$author,$staffassigned,$ticket_id,$status);
			}

		} 
		else 
		{

			/*
			|--------------------------------------------------------------------------
			|
			| 	Check if the tag is room
			|
			|--------------------------------------------------------------------------
			|
			*/
			$room = Room::location($tag)->first();
			if( count($room) > 0 ) 
			{
				Ticket::generateRoomTicket($room->id,'complaint',$ticketname,$details,$author,$staffassigned,$ticket_id,$status);
			}
			else
			{

				/*
				|--------------------------------------------------------------------------
				|
				| 	Create general ticket
				|
				|--------------------------------------------------------------------------
				|
				*/
				Ticket::generateTicket('complaint',$ticketname,$details,$author,$staffassigned,$ticket_id,$status);
			}
		}

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

		/*
		|--------------------------------------------------------------------------
		|
		| 	Check maintenance type
		|
		|--------------------------------------------------------------------------
		|
		*/
		if($type == 'maintenance')
		{
			$maintenancetype = 'maintenance type:'. $maintenancetype . ',details:';
		}
		else
		{
			 $maintenancetype = "";
		}

		try
		{
			$item = Itemprofile::where('propertynumber','=',trim($propertynumber))->first();
			if(count($item) == 0)
			{
				return Redirect::to("ticket/$id/edit")
						->withInput()
						->withErrors([ 'Invalid Property Number' ]);
			}

			$propertynumber = $item->id;
		} 
		catch ( Exception $e ) 
		{
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
		} 
		catch (Exception $e) 
		{
			Session::flash('error-message','Error occured while processiong your data');
			return Redirect::to("ticket/$id/edit")
				->withInput();
		}

		Session::flash('success-message','Ticket Generated');
		return Redirect::to('ticket');

	}

	/**
	 * Transfer ticket to another user.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function transfer($id)
	{
		/*
		|--------------------------------------------------------------------------
		|
		| 	Initialize
		|
		|--------------------------------------------------------------------------
		|
		*/
		$id = $this->sanitizeString(Input::get('id'));
		$staffassigned = $this->sanitizeString(Input::get('transferto'));

		/*
		|--------------------------------------------------------------------------
		|
		| 	Validation
		|
		|--------------------------------------------------------------------------
		|
		*/
		$validator = Validator::make([
				'Ticket ID' => $id,
				'Staff Assigned' => $staffassigned
			],Ticket::$transferRules);

		if($validator->fails())
		{
			Session::flash('error-message','Problem encountered while processing your request');
			return Redirect::to('ticket');
		}

		/*
		|--------------------------------------------------------------------------
		|
		| 	Transfer....
		|
		|--------------------------------------------------------------------------
		|
		*/
		try
		{
			Ticket::transferTicket($id,$staffassigned);
		} 
		catch ( Exception $e ) 
		{
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
			try
			{
				Ticket::closeTicket($id);
				return json_encode('success');
			} 
			catch ( Exception $e ) 
			{
				return json_encode('error');
			}
		}
	}

	/**
	 * Restore the specified resource
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function reOpenTicket($id)
	{
		if(Request::ajax())
		{
			try
			{
				Ticket::reOpenTicket($id);
				return json_encode('success');
			} 
			catch ( Exception $e ) 
			{
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
			do
			{	

				$ticket =  Ticket::where('id','=',$id)
							->orderBy('id','desc')
							->with('user')
							->first();

				try 
				{
					$id = $ticket->ticket_id;
					array_push($arraylist,$ticket);
				} 
				catch( Exception $e ) 
				{ 
					$cond = false;
				}


			} while ( $cond == true);

			return json_encode([ 'data'=> $arraylist ]);
		}

		try
		{
			$ticket = Ticket::with('itemprofile')
								->where('id','=',$id)
								->first();
			return View::make('ticket.history')
				->with('ticket',$ticket)
				->with('id',$id);
		} 
		catch ( Exception $e ) 
		{

			Session::flash('error-message','Problem encountered while processing your request');
			return Redirect::to('ticket');

		}
	}

	/**
	*
	*	@return ajax: 'success' or 'error'
	*	normal: view with prompt
	*
	*
	*/
	public function resolve()
	{

		/*
		|--------------------------------------------------------------------------
		|
		| 	Intantiate Values
		|
		|--------------------------------------------------------------------------
		|
		*/
		$details = $this->sanitizeString(Input::get('details'));
		$id = $this->sanitizeString(Input::get('id'));
		$status = 'Open';
		$underrepair = false;

		/*
		|--------------------------------------------------------------------------
		|
		| 	check if the status will be changed
		|
		|--------------------------------------------------------------------------
		|
		*/
		if(Input::has('underrepair'))
		{
			$underrepair = true;
		}

		/*
		|--------------------------------------------------------------------------
		|
		| 	check if the the ticket will be closed
		|
		|--------------------------------------------------------------------------
		|
		*/
		if(Input::has('close'))
		{
			$status = "Closed";
		}

		/*
		|--------------------------------------------------------------------------
		|
		| 	call function resolve ticket
		|
		|--------------------------------------------------------------------------
		|
		*/
		Ticket::resolveTicket($id,$details,$status,$underrepair);

		/*
		|--------------------------------------------------------------------------
		|
		| 	return successful
		|
		|--------------------------------------------------------------------------
		|
		*/
		Session::flash('success-message','Ticket Closed');
		return Redirect::to('ticket');
	}

	/**
	*
	*	complain process
	*
	*/
	public function complaint()
	{
		return Redirect::to('ticket/complaint');
	}

	/**
	*
	*	@return complaint view
	*	@return opened ticket
	*
	*/
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

	/**
	*
	*	@param $id requires pc id
	*	@return list of pc ticket
	*
	*/
	public function getPcTicket($id)
	{
		if(Request::ajax())
		{

			/*
			|--------------------------------------------------------------------------
			|
			| 	get pc id
			|
			|--------------------------------------------------------------------------
			|
			*/
			$pc = PcTicket::where('pc_id','=',$id)->lists('id');

			/*
			|--------------------------------------------------------------------------
			|
			| 	return ticket with pc information
			|
			|--------------------------------------------------------------------------
			|
			*/
			return json_encode(
			[
				'data' => Ticket::whereIn('id',function($query) use ($id)
				{

					/*
					|--------------------------------------------------------------------------
					|
					| 	checks if pc is in ticket
					|
					|--------------------------------------------------------------------------
					|
					*/
					$query->where('pc_id','=',$id)
						->from('pc_ticket')
						->lists('ticket_id');
				})->get()
			]);
		}
	}

	/**
	*
	*	@param $tag 
	*	@return item information 
	*	@return is existing room
	*	@return pc information
	*
	*/
	public function getTagInformation()
	{

		/*
		|--------------------------------------------------------------------------
		|
		| 	uses ajax request
		|
		|--------------------------------------------------------------------------
		|
		*/
		if(Request::ajax())
		{
			$tag = $this->sanitizeString(Input::get('id'));
			/*
			|--------------------------------------------------------------------------
			|
			| 	Check if the tag is equipment
			|
			|--------------------------------------------------------------------------
			|
			*/
			$itemprofile = ItemProfile::propertyNumber($tag)->first();
			if( count($itemprofile) > 0)
			{

				/*
				|--------------------------------------------------------------------------
				|
				| 	Check if the equipment is connected to pc
				|
				|--------------------------------------------------------------------------
				|
				*/
				$pc = Pc::isPc($tag);
				if(count($pc) > 0)
				{
					$pc = Pc::with('systemunit')->with('monitor')->with('keyboard')->with('avr')->find($pc->id);
					return json_encode($pc);
				} 
				else
				{

					/*
					|--------------------------------------------------------------------------
					|
					| 	Create equipment ticket
					|
					|--------------------------------------------------------------------------
					|
					*/
					return json_encode($itemprofile);
				}

			} 

			/*
			|--------------------------------------------------------------------------
			|
			| 	Check if the tag is room
			|
			|--------------------------------------------------------------------------
			|
			*/
			$room = Room::location($tag)->first();
			if( count($room) > 0 ) 
			{
				return json_encode($room);
			}

			/*
			|--------------------------------------------------------------------------
			|
			| 	return false if no item found
			|
			|--------------------------------------------------------------------------
			|
			*/
			return json_encode('error');
		}

		$tag = $this->sanitizeString(Input::get('tag'));

		/*
		|--------------------------------------------------------------------------
		|
		| 	Check if the tag is equipment
		|
		|--------------------------------------------------------------------------
		|
		*/
		$itemprofile = ItemProfile::propertyNumber($tag)->first();
		if( count($itemprofile) > 0)
		{

			/*
			|--------------------------------------------------------------------------
			|
			| 	Check if the equipment is connected to pc
			|
			|--------------------------------------------------------------------------
			|
			*/
			$pc = Pc::isPc($tag);
			if(count($pc) > 0)
			{
				return $pc;
			} 
			else
			{

				/*
				|--------------------------------------------------------------------------
				|
				| 	Create equipment ticket
				|
				|--------------------------------------------------------------------------
				|
				*/
				return $itemprofile;
			}

		} 
		else 
		{

			/*
			|--------------------------------------------------------------------------
			|
			| 	Check if the tag is room
			|
			|--------------------------------------------------------------------------
			|
			*/
			$room = Room::location($tag)->first();
			if( count($room) > 0 ) 
			{
				return $room;
			}
		}

		/*
		|--------------------------------------------------------------------------
		|
		| 	return false if no item found
		|
		|--------------------------------------------------------------------------
		|
		*/
		return json_encode('error');
	}

}
