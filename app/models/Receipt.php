<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Receipt extends Eloquent{
	use SoftDeletingTrait;

	//Database driver
	/*
		1 - Eloquent (MVC Driven)
		2 - DB (Directly query to SQL database, no model required)
	*/

	//The table in the database used by the model.
	protected $table  = 'receipt';
	protected $dates = ['deleted_at'];
	//The attribute that used as primary key.
	protected $primaryKey = 'id';

	public $timestamps = false;

	protected $fillable = ['number','POno','POdate','invoiceno','invoicedate','fundcode'];

	//Validation rules!
	public static $rules = array(
		'Acknowledgement Receipt' => 'required|min:2|max:25',
		'P.O. Number' => 'required|min:2|max:25',
		'P.O. Date' => 'required|min:2|max:25|date',
		'Invoice Number' => 'required|min:2|max:25',
		'Invoice Date' => 'required|min:2|max:25|date',
		'Fund Code' => 'min:2|max:25'
	);

	public static $updateRules = array(
		'Acknowledgement Receipt' => 'min:2|max:25',
		'P.O. Number' => 'min:2|max:25',
		'P.O. Date' => 'min:2|max:25|date',
		'Invoice Number' => 'min:2|max:25',
		'Invoice Date' => 'min:2|max:25|date',
		'Fund Code' => 'min:2|max:25'
	);


}
