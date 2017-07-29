<?php

class Purpose extends Eloquent{

  protected $table = 'purpose';

	public $timestamps = true;

	protected $fillable = ['title','description'];

  public static $rules = [
    'title' => 'required',
    'description' => 'required'
  ];

  public static $updateRules = [
    'title' => '',
    'description' => ''
  ];

}
