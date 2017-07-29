<?php

class ItemTicket extends Eloquent{
	protected $table = 'item_ticket';
	protected $primaryKey = 'id';

	public $timestamps = true;
	public $fillable = ['item_id','ticket_id'];

}