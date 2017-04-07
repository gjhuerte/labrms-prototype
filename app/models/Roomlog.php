 <?php
 use Illuminate\Database\Eloquent\SoftDeletingTrait;
class Roomlog extends Eloquent{
		use SoftDeletingTrait;
	//Database driver
		/*
			1 - Eloquent (MVC Driven)
			2 - DB (Directly query to SQL database, no model required)
		*/

		//The table in the database used by the model.
		protected $table = 'roomlog';
		protected $dates = ['deleted_at'];
		public $fillable = ['timein','facultyincharge','subject','workingunits','staffincharge'];
		//The attribute that used as primary key.
		public $timestamps = true; 
		//Validation rules!
		public static $rules = array(
			'room name' => 'exists:room,id',
			'time start' => 'required|date',
			'time end' =>'required|date',
			'section' => 'required|between:8,15',
			'faculty-in-charge' =>'required|between:5,100',
			'number of working units' =>'required|integer'
		);

		public static $updateRules = array();

		public function room()
		{
			return $this->belongsTo('Room');
		}
}