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
			'Operating System Key' => 'min:2|max:50|unique:pc,oskey',
      'AVR' => 'exists:itemprofile,propertynumber',
      'Monitor' => 'exists:itemprofile,propertynumber',
      'System Unit' => 'exists:itemprofile,propertynumber',
      'Keyboard' => 'exists:itemprofile,propertynumber'
		);

		public static $updateRules = array(
			'Operating System Key' => 'min:2|max:50',
      'AVR' => 'exists:itemprofile,propertynumber',
      'Monitor' => 'exists:itemprofile,propertynumber',
      'System Unit' => 'exists:itemprofile,propertynumber',
      'Keyboard' => 'exists:itemprofile,propertynumber'
		);

		public function roominventory()
		{
			return $this->hasOne('Roominventory','room_id','id');
		}

		public function systemunit()
		{
			return $this->belongsTo('Itemprofile','systemunit_id','id');
		}

		public function monitor()
		{
			return $this->belongsTo('Itemprofile','monitor_id','id');
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
