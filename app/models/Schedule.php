 <?php
 use Illuminate\Database\Eloquent\SoftDeletingTrait;
class Schedule extends Eloquent{
		use SoftDeletingTrait;
	//Database driver
		/*
			1 - Eloquent (MVC Driven)
			2 - DB (Directly query to SQL database, no model required)
		*/

		//The table in the database used by the model.
		protected $table = 'schedule';
		protected $dates = ['deleted_at'];
		//The attribute that used as primary key.
		public $fillable = ['day','timein','timeout','facultyincharge','courseyearsection','subject','semester'];
		//Validation rules!
		public $timestamps = false;
		public static $rules = array(
			'day' => 'required|min:1|max:8',
			'start time' => 'required',
			'end time' =>'required',
			'faculty-in-charge' =>'required|min:5|max:100',
			'course year & section' =>'required|min:5|max:100',
			'subject' =>'required|min:5|max:100',
			'semester' =>'required|min:1|max:100',
			'room name' => 'exists:room,id'
		);

		public static $updateRules = array(
			'day' => 'required|min:1|max:8',
			'start time' => 'required',
			'end time' =>'required',
			'faculty-in-charge' =>'required|min:5|max:100',
			'course year & section' =>'required|min:5|max:100',
			'subject' =>'required|min:5|max:100',
			'semester' =>'required|min:1|max:100',
			'room name' => 'exists:room,id'
			);

		public function room()
		{
			return $this->belongsTo('Room','room_id','id');
		}
}