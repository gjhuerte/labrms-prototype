 <?php

class RoomSchedule extends Eloquent{
	//Database driver
	/*
		1 - Eloquent (MVC Driven)
		2 - DB (Directly query to SQL database, no model required)
	*/

	//The table in the database used by the model.
	protected $table = 'roomschedule';

	//The attribute that used as primary key.
	protected $primaryKey = 'id';
	public $timestamps = false;
	public $fillable = ['room_id','faculty','academicyear','semester','day','timein','timeout','subject','section'];
	//Validation rules!
	public static $rules = array(
		'subject' => 'required|min:2|max:50|unique:itemtype,name'
	);