<?php

class Holiday extends Eloquent{
  protected $table = 'holiday';
  protected $primaryKey = 'id';

  public $timestamps = true;

  public $fillable = ['title','date'];

  public static $rules = [
  	'title' => 'required',
  	'date' => 'required'
  ];

public static $updateRules = [
  	'title' => '',
  	'date' => ''
  ];
}
