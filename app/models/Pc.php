 <?php
class Pc extends Eloquent{
	//Database driver
		/*
			1 - Eloquent (MVC Driven)
			2 - DB (Directly query to SQL database, no model required)
		*/
		use SoftDeletingTrait;
		//The table in the database used by the model.
		protected $table = 'pc';
		protected $dates = ['deleted_at'];
		public $timestamps = false;
		public $fillable = ['oskey','mouse'];
		//Validation rules!
		protected $primaryKey = 'id';
		public static $rules = array(
			'oskey' => 'required|min:2|max:50|unique:pc,oskey',
			'mouse' => 'boolean'
		);

		public static $updateRules = array(
			'oskey' => 'required|min:2|max:50|unique:pc,oskey',
			'mouse' => 'boolean'
		);

		public function roominventory()
		{
			return $this->hasOne('Roominventory','room_id','id');
		}

		public function systemunit()
		{
			return $this->belongsTo('Itemprofile','systemunit_id','id');
		}

		public function display()
		{
			return $this->belongsTo('Itemprofile','display_id','id');
		}
		public function keyboard()
		{
			return $this->belongsTo('Itemprofile','keyboard_id','id');
		}
		public function avr()
		{
			return $this->belongsTo('Itemprofile','avr_id','id');
		}

}