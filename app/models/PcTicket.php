<?php

class PcTicket extends Eloquent{
	protected $table = 'pc_ticket';
	protected $primaryKey = 'id';

	public $timestamps = true;
	public $fillable = ['pc_id','ticket_id'];

	public function ticket()
	{
		return $this->hasMany('Ticket','ticket_id','ticket_id');
	}

	public function scopeTicket($query,$value)
	{
		$query->where('ticket_id','=',$value);
	}

}