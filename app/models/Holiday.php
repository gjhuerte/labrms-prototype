<?php

class Holiday extends Eloquent{
  protected $table = 'holiday';
  protected $primaryKey = 'id';

  public $timestamps = true;

  public $fillable = ['title','date'];
}
