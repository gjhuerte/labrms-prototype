<?php

class Ticket extends Eloquent{

	protected $table = 'ticket';
	public $timestamps = true;

	public $fillable = ['item_id','tickettype','ticketname','details','author','staffassigned','ticket_id','status'];
	protected $primaryKey = 'id';

	public static $rules = array(
		
		'Item Id' => 'required|exists:itemprofile,id',
		'Ticket Type' => 'required|min:2|max:100',
		'Ticket Name' => 'required|min:2|max:100',
		'Details' => 'required|min:2|max:500',
		'Ticket Id' => 'exists:ticket,id',
		'Status' => 'boolean'
	);

	public static $complaintRules = array(
		'Ticket Title' => 'required|min:2|max:100',
		'Details' => 'required|min:2|max:500',
	);

	public static $transferRules = array(
		'Ticket ID' => 'required|exists:ticket,id',
		'Staff Assigned' => 'required|exists:user,id',
	);

	public function user()
	{
		return $this->hasOne('user','id','staffassigned');
	}

	public function itemprofile()
	{
		return $this->belongsToMany('ItemProfile','item_ticket','item_id','ticket_id');
	}

	public function room()
	{
		return $this->belongsToMany('Room','room_ticket','room_id','ticket_id');
	}

	public function pc()
	{
		return $this->belongsToMany('Pc','pc_ticket','pc_id','ticket_id');
	}

	public function scopeTickettype($query,$value)
	{
		return $query->where('tickettype','=',$value);
	}

	public function scopeStatus($query,$value)
	{
		return $query->where('status','=',$value);
	}

	public function scopeStaffassigned($query,$value)
	{
		return $query->where('staffassigned','=',$value);
	}

	public function setTickettypeAttribute($value)
	{
		$this->attributes['tickettype'] = ucwords($value);
	}

	public function getTickettypeAttribute($value)
	{
		return ucwords($value);
	}

	public function getDetailsAttribute($value)
	{
		return ucwords($value);
	}

	public function getTicketnameAttribute($value)
	{
		return ucwords($value);
	}

	/**
	*
	*	@param $pc_id accepts pc id
	*	@param $tickettype: 'receive','maintenance','complaint','action taken', 'lent', 'incident'
	*	@param $ticketname
	*	@param $author can be the system user or other
	*	@param $staffassigned can be the system user or other
	*	@param $ticket_id null if it is the original ticket
	*	@param $status = 'Open' , 'Closed', 'Transferred'
	*
	*/
	public static function generatePcTicket($pc_id,$tickettype,$ticketname,$details,$author,$staffassigned,$ticket_id,$status)
	{
		DB::transaction(function() use ($pc_id,$tickettype,$ticketname,$details,$author,$staffassigned,$ticket_id,$status)
		{			

			/*
			|--------------------------------------------------------------------------
			|
			| 	Calls function generate from ticket table
			|	returns object
			|
			|--------------------------------------------------------------------------
			|
			*/
			$ticket = Ticket::generateTicket($tickettype,$ticketname,$details,$author,$staffassigned,$ticket_id,$status);		

			/*
			|--------------------------------------------------------------------------
			|
			| 	Connects record from pc table to ticket table
			|
			|--------------------------------------------------------------------------
			|
			*/
			Pc::find($pc_id)->ticket()->attach($ticket->id);
		});
	}

	/**
	*
	*	@param $pc_id accepts pc id
	*	@param $tickettype: 'receive','maintenance','complaint','action taken', 'lent', 'incident'
	*	@param $ticketname
	*	@param $author can be the system user or other
	*	@param $staffassigned can be the system user or other
	*	@param $ticket_id null if it is the original ticket
	*	@param $status = 'Open' , 'Closed', 'Transferred'
	*
	*/
	public static function generateEquipmentTicket($item_id,$tickettype,$ticketname,$details,$author,$staffassigned,$ticket_id,$status)
	{
		DB::transaction(function() use ($item_id,$tickettype,$ticketname,$details,$author,$staffassigned,$ticket_id,$status)
		{			

			/*
			|--------------------------------------------------------------------------
			|
			| 	Calls function generate from ticket table
			|	returns object
			|
			|--------------------------------------------------------------------------
			|
			*/
			$ticket = Ticket::generateTicket($tickettype,$ticketname,$details,$author,$staffassigned,$ticket_id,$status);	

			/*
			|--------------------------------------------------------------------------
			|
			| 	Connects record from item profile table to ticket table
			|
			|--------------------------------------------------------------------------
			|
			*/
			ItemProfile::find($item_id)->ticket()->attach($ticket->id);
		});
	}

	/**
	*
	*	@param $pc_id accepts pc id
	*	@param $tickettype: 'receive','maintenance','complaint','action taken', 'lent', 'incident'
	*	@param $ticketname
	*	@param $author can be the system user or other
	*	@param $staffassigned can be the system user or other
	*	@param $ticket_id null if it is the original ticket
	*	@param $status = 'Open' , 'Closed', 'Transferred'
	*
	*/
	public static function generateRoomTicket($room_id,$tickettype,$ticketname,$details,$author,$staffassigned,$ticket_id,$status)
	{
		DB::transaction(function() use ($room_id,$tickettype,$ticketname,$details,$author,$staffassigned,$ticket_id,$status)
		{			

			/*
			|--------------------------------------------------------------------------
			|
			| 	Calls function generate from ticket table
			|	returns object
			|
			|--------------------------------------------------------------------------
			|
			*/
			$ticket = Ticket::generateTicket($tickettype,$ticketname,$details,$author,$staffassigned,$ticket_id,$status);	

			/*
			|--------------------------------------------------------------------------
			|
			| 	Connects record from room table to ticket table
			|
			|--------------------------------------------------------------------------
			|
			*/
			Room::find($room_id)->ticket()->attach($ticket->id);
		});
	}

	/**
	*
	*	@param $pc_id accepts pc id
	*	@param $tickettype: 'receive','maintenance','complaint','action taken', 'lent', 'incident'
	*	@param $ticketname
	*	@param $author can be the system user or other
	*	@param $staffassigned can be the system user or other
	*	@param $ticket_id null if it is the original ticket
	*	@param $status = 'Open' , 'Closed', 'Transferred'
	*	@return $ticket object generated
	*
	*/
	public static function generateTicket($tickettype,$ticketname,$details,$author,$staffassigned,$ticket_id,$status)
	{
		$ticket = new Ticket;
		$ticket->tickettype = $tickettype;
		$ticket->ticketname = $ticketname;
		$ticket->details = $details;
		$ticket->author = $author;
		$ticket->staffassigned = $staffassigned;
		$ticket->ticket_id = $ticket_id;
		$ticket->status = $status;
		$ticket->save();
		return $ticket;
	}

	/**
	*
	*	@param $id accepts id
	*	@return $ticket object generated
	*
	*/
	public static function closeTicket($id)
	{
		$ticket = Ticket::find($id);
		$ticket->status = 'Closed';
		$ticket->save();

		return $ticket;
	}

	/**
	*
	*	@param $id accepts id
	*	@return $ticket object generated
	*
	*/
	public static function reOpenTicket($id)
	{
		$ticket = "";
		
		DB::transaction(function() use ($id) {
			$ticket = Ticket::find($id);

			/*
			|--------------------------------------------------------------------------
			|
			| 	call function generate ticket
			|
			|--------------------------------------------------------------------------
			|
			*/
			$ticket = Ticket::generateTicket(
							$ticket->tickettype,
							$ticket->ticketname,
							$ticket->details,
							$ticket->author,
							$ticket->staffassigned,
							$ticket->id,
							'Open'
						);
		});

		return $ticket;
	}

	/**
	*
	*	@param $id accepts id
	*	@return $ticket object generated
	*
	*/
	public static function setTicketAsTransferred($id)
	{
		$ticket = Ticket::find($id);
		$ticket->status = 'Transferred';
		$ticket->save();

		return $ticket;
	}


	/**
	*
	*	@param $id accepts ticket id
	*	@param $details accepts details
	*	@param $status receives either 'Closed' or 'Open'
	*	@param $underrepair receives boolean value
	*
	*/
	public static function resolveTicket($id,$details,$status,$underrepair)
	{
		/*
		|--------------------------------------------------------------------------
		|
		| 	initial values
		|
		|--------------------------------------------------------------------------
		|
		*/
		$author = Auth::user()->firstname . " " . Auth::user()->middlename . " " . Auth::user()->lastname;
		$staffassigned = Auth::user()->id;

		/*
		|--------------------------------------------------------------------------
		|
		| 	call function close ticket
		|
		|--------------------------------------------------------------------------
		|
		*/
		if($status == 'Closed')
		{
			$ticket = Ticket::closeTicket($id);
		}

		/*
		|--------------------------------------------------------------------------
		|
		| 	set the item status to underrepair
		|
		|--------------------------------------------------------------------------
		|
		*/
		if($underrepair == true)
		{
			$tag = Ticket::find($id);

			/*
			|--------------------------------------------------------------------------
			|
			| 	Check if the equipment is connected to pc
			|
			|--------------------------------------------------------------------------
			|
			*/
			$pc = PcTicket::ticket($tag)->first();
			if(count($pc) > 0)
			{
				Pc::setItemStatus($pc->id,'for repair');
			} 
			
			/*
			|--------------------------------------------------------------------------
			|
			| 	Check if the tag is equipment
			|
			|--------------------------------------------------------------------------
			|
			*/
			$itemticket = ItemTicket::ticket($tag)->first();
			if( count($itemticket) > 0)
			{
				ItemProfile::setItemStatus($itemticket->item_id,'for repair');
			} 
		}

		/*
		|--------------------------------------------------------------------------
		|
		| 	call function generate ticket
		|
		|--------------------------------------------------------------------------
		|
		*/
		$ticket = Ticket::generateTicket('action taken','Action Taken',$details,$author,$staffassigned,$ticket->id,$status);
	}

	public static function transferTicket($id,$staffassigned)
	{
		/*
		|--------------------------------------------------------------------------
		|
		| 	initial values
		|
		|--------------------------------------------------------------------------
		|
		*/
		$status = 'Open';

		/*
		|--------------------------------------------------------------------------
		|
		| 	call function close ticket
		|
		|--------------------------------------------------------------------------
		|
		*/
		$ticket = Ticket::setTicketAsTransferred($id);

		/*
		|--------------------------------------------------------------------------
		|
		| 	call function generate ticket
		|
		|--------------------------------------------------------------------------
		|
		*/
		$ticket = Ticket::generateTicket($ticket->tickettype,$ticket->ticketname,$ticket->details,$ticket->author,$staffassigned,$ticket->id,$status);
	}
	
}