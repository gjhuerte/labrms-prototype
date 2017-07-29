 <?php
class Pc extends Eloquent{
	//Database driver
		/*
			1 - Eloquent (MVC Driven)
			2 - DB (Directly query to SQL database, no model required)
		*/
		//The table in the database used by the model.
		protected $table = 'pc';
		protected $primaryKey = 'id';
		protected $dates = ['deleted_at'];
		public $timestamps = false;
		public $fillable = ['oskey','mouse','keyboard_id','systemunit_id','monitor_id','avr_id'];
		//Validation rules!
		public static $rules = array(
			'Operating System Key' => 'required|min:2|max:50|unique:pc,oskey',
		      'avr' => 'required|exists:itemprofile,propertynumber',
		      'Monitor' => 'exists:itemprofile,propertynumber',
		      'System Unit' => 'required|exists:itemprofile,propertynumber',
		      'Keyboard' => 'exists:itemprofile,propertynumber'
		);

		public static $updateRules = array(
			'Operating System Key' => 'min:2|max:50',
		);

		public function roominventory()
		{
			return $this->hasOne('RoomInventory','room_id','systemunit_id');
		}

		public function systemunit()
		{
			return $this->belongsTo('ItemProfile','systemunit_id','id');
		}

		public function monitor()
		{
			return $this->belongsTo('ItemProfile','monitor_id','id');
		}
		public function keyboard()
		{
			return $this->belongsTo('ItemProfile','keyboard_id','id');
		}

		public function avr()
		{
			return $this->belongsTo('ItemProfile','avr_id','id');
		}

	    public static function separateArray($value)
	    {
	        return explode(',', $value);
	    }

}
