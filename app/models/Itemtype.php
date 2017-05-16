 <?php

class Itemtype extends Eloquent{
		use SoftDeletingTrait;
	//Database driver
		/*
			1 - Eloquent (MVC Driven)
			2 - DB (Directly query to SQL database, no model required)
		*/

		//The table in the database used by the model.
		protected $table = 'itemtype';
		protected $dates = ['deleted_at'];

		//The attribute that used as primary key.
		protected $primaryKey = 'id';
		public $timestamps = true;
		public $fillable = ['name','description','field'];
		//Validation rules!
		public static $rules = array(
			'name' => 'required|min:2|max:50|unique:itemtype,name',
			'description' => 'required|min:5|max:450',
      'field'=>'required|max:450'
		);

		public static $updateRules = array(
			'name' => 'min:2|max:50',
			'description' => 'min:5|max:450',
      'field'=>'max:450'
		);

    public static function getField($value)
    {
        return explode(',', $value);
    }
}
