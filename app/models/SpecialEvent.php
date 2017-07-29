<?php

class SpecialEvent extends Eloquent{
  protected $table = 'event';
  protected $primaryKey = 'id';

  public $timestamps = true;

  public $fillable = ['title','date','repeating','repeatingFormat'];

  public static $rules = [
  	'title' => 'required',
  	'date' => 'required|date',
  ];

public static $updateRules = [
  	'title' => '',
  	'date' => ''
  ];
}
