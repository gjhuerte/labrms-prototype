<?php

 use Illuminate\Database\Eloquent\SoftDeletingTrait;
class ActionTaken extends Eloquent{
		use SoftDeletingTrait;
	
	protected $table = 'actiontaken';
		protected $dates = ['deleted_at'];
	public $timestamps = true;
	const UPDATED_AT = null;

	public $fillable = ['ticket_id','description','staff'];

	public static $rules = [
		'details' => 'required|between:5,100|string',
		'incident' => 'required|exists:ticket,id'
	];

	public function ticket()
	{
		return $this->belongsTo('Ticket','ticket_id','id');
	}

	public function generateActionTaken($incident,$description)
	{
		$ticket = Ticket::find($incident);
		$actiontaken = new ActionTaken([
			'description' => $description,
			'staff' => Auth::user()->id,
			'created_at' => Carbon\Carbon::now()
		]); 

		$ticket = Ticket::find($incident);
		$ticket->actiontaken()->save($actiontaken);
	}
}