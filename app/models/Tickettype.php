<?php
class Tickettype extends Eloquent{
 //Database driver
   /*
     1 - Eloquent (MVC Driven)
     2 - DB (Directly query to SQL database, no model required)
   */
   //The table in the database used by the model.


   //The table in the database used by the model.
   protected $table = 'tickettype';
   public $fillable = ['type','categories'];
   public $timestamps = true;
   //Validation rules!
   protected $primaryKey = 'id';

}
