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
		'Author' => 'required|min:2|max:100',
		'Staff Assigned' => 'min:2|max:100',
		'Ticket Id' => 'exists:ticket,id',
		'Status' => 'boolean'
	);

	public static $updateRules = array(
		
		'Item Id' => 'exists:itemprofile,id',
		'Ticket Type' => 'min:2|max:100',
		'Ticket Name' => 'min:2|max:100',
		'Details' => 'min:2|max:500',
		'Author' => 'min:2|max:100',
		'Staff Assigned' => 'min:2|max:100',
		'Ticket Id' => 'exists:ticket,id',
		'Status' => 'boolean'
	);

	public static function generateTicket($item_id,$ticketname,$details,$author,$staffassigned,$ticket_id,$status)
	{
		$ticket = new Ticket;
		$ticket->ticketname = $ticketname;
		$ticket->details = $details;
		$ticket->author = $author;
		$ticket->staffassigned = $staffassigned;
		$ticket->ticket_id = $ticket_id;
		$ticket->status = $status;
		$ticket->save();
	}

	public function itemprofile()
	{
		return $this->hasOne('itemprofile','id','item_id');
	}

	public function user()
	{
		return $this->hasOne('user','id','staffassigned');
	}

	
}