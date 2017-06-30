<?php

class Purpose extends Eloquent{

  protected $table = 'purpose';

	public $timestamps = true;

	protected $fillable = ['title','description'];

}
