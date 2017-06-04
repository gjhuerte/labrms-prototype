<?php

class Ticket extends Eloquent{
	use SoftDeletingTrait;
	protected $table = 'ticket';
	protected $dates = ['deleted_at'];
	public $timestamps = true;

	public $fillable = ['item_id','tickettype','ticketname','details','author','staffassigned','ticket_id','status'];
	protected $primaryKey = 'id';
	public static $rules = array(
		
		'Item Id' => 'required|alpha|exists:itemprofile,id',
		'Ticket Type' => 'required|alpha|min:2|max:100',
		'Ticket Name' => 'required|alpha|min:2|max:100',
		'Details' => 'required|alpha|min:2|max:500',
		'Author' => 'required|alpha|min:2|max:100',
		'Staff Assigned' => 'alpha|min:2|max:100',
		'Ticket Id' => 'exists:ticket,id',
		'Status' => 'boolean'
	);

	public static $updateRules = array(
		
		'Item Id' => 'required|alpha|exists:itemprofile,id',
		'Ticket Type' => 'required|alpha|min:2|max:100',
		'Ticket Name' => 'required|alpha|min:2|max:100',
		'Details' => 'required|alpha|min:2|max:500',
		'Author' => 'required|alpha|min:2|max:100',
		'Staff Assigned' => 'alpha|min:2|max:100',
		'Ticket Id' => 'exists:ticket,id',
		'Status' => 'boolean'
	);

	
}