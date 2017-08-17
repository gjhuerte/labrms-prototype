<?php

class RoomTicket extends Eloquent{
	protected $table = 'room_ticket';
	protected $primaryKey = 'id';

	public $timestamps = true;
	public $fillable = ['room_id','ticket_id'];

	public function ticket()
	{
		return $this->belongsTo('Ticket','ticket_id','id');
	}

	public function room()
	{
		return $this->belongsTo('Room','room_id','id');
	}

	public function scopeTicket($query,$value)
	{
		$query->where('ticket_id','=',$value);
	}

}