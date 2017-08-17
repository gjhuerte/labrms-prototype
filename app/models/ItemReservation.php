<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class ItemReservation extends Eloquent{
	use  SoftDeletingTrait;

	//Database driver
	/*
		1 - Eloquent (MVC Driven)
		2 - DB (Directly query to SQL database, no model required)
	*/ 

	//The table in the database used by the model.
	protected $table  = 'item_reservation';
	protected $dates = ['deleted_at'];
	//The attribute that used as primary key.
	protected $primaryKey = 'id';

	public $timestamps = false;
	
	//Validation rules!

}