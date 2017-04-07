 <?php
 use Illuminate\Database\Eloquent\SoftDeletingTrait;
class Softwarelist extends Eloquent{
		use SoftDeletingTrait;
	//Database driver
		/*
			1 - Eloquent (MVC Driven)
			2 - DB (Directly query to SQL database, no model required)
		*/

		//The table in the database used by the model.
		protected $table = 'softwarelist';
		protected $dates = ['deleted_at'];
		public $timestamps = true;
		public $fillable = ['name','description','licensetype','requirement'];
		//Validation rules!
		public static $rules = array(
			'name' => 'required|min:5|max:100|unique:softwarelist,name',
			'description' => 'required|min:5|max:450',
			'license type' => 'required|min:5|max:100',
			'software type' => 'required|exists:softwaretype,type',
			'requirement' => 'required|min:5|max:100'
		);

		public static $updateRules = array(
			'name' => 'required|min:5|max:100',
			'description' => 'required|min:5|max:450',
			'license type' => 'required|min:5|max:100',
			'software type' => 'required|exists:softwaretype,type',
			'requirement' => 'required|min:5|max:100'
		);

		public function softwaretype()
		{
			return $this->belongsTo('Softwaretype','softwaretype','type');
		}
}