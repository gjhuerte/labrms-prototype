<?php
class MaintenanceActivity extends Eloquent{
 //Database driver
   /*
     1 - Eloquent (MVC Driven)
     2 - DB (Directly query to SQL database, no model required)
   */
   //The table in the database used by the model.


   //The table in the database used by the model.
   protected $table = 'maintenanceactivity';
   public $fillable = ['type','problem'];
   public $timestamps = true;
   //Validation rules!
   protected $primaryKey = 'id';

   public static $rules = [
     'type' => 'required',
     'problem / category' => 'required|regex:/^[\pL\s\-]+$/u'
   ];

   public static $updateRules = [
     'problem / category' => 'required|regex:/^[\pL\s\-]+$/u'
   ];

}
