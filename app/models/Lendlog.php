 <?php
 use Illuminate\Database\Eloquent\SoftDeletingTrait;
class Lendlog extends Eloquent{
		use SoftDeletingTrait;
	//Database driver
		/*
			1 - Eloquent (MVC Driven)
			2 - DB (Directly query to SQL database, no model required)
		*/

		//The table in the database used by the model.
		protected $table = 'lendlog';
		protected $dates = ['deleted_at'];
		public $fillable = ['timein','timeout','facultyincharge','clientname','date'];
		public $timestamps = false;
		//Validation rules!
		public static $rules = array(
			'property number' => 'required|exists:itemprofile,property_number',
			'location' => 'required|exists:room,name',
			'faculty-in-charge' => 'required|between:5,100'
		);

		public function itemprofile()
		{
			return $this->belongsTo('Itemprofile','item_id','id');
		}

		public function user()
		{
			return $this->belongsTo('User','clientname','username');
		}
}