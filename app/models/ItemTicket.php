<?php

class ItemTicket extends Eloquent{
	protected $table = 'item_ticket';
	protected $primaryKey = 'id';

	public $timestamps = true;
	public $fillable = ['item_id','ticket_id'];

	public function ticket()
	{
		return $this->belongsTo('Ticket','ticket_id','id');
	}

	public function itemprofile()
	{
		return $this->belongsTo('ItemProfile','item_id','id');
	}

	public function scopeTicket($query,$value)
	{
		$query->where('ticket_id','=',$value);
	}

}