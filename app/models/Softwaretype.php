 <?php
 use Illuminate\Database\Eloquent\SoftDeletingTrait;
class Softwaretype extends Eloquent{
		use SoftDeletingTrait;
	//Database driver
		/*
			1 - Eloquent (MVC Driven)
			2 - DB (Directly query to SQL database, no model required)
		*/

		//The table in the database used by the model.
		protected $table = 'softwaretype';
		protected $dates = ['deleted_at'];
		public $fillable = ['description'];
		//The attribute that used as primary key.
		protected $primaryKey = 'type';

		//Validation rules!
		public static $rules = array(
			'description' => 'required|min:5|max:450'
			
		);

		public static $updateRules = array(
			'description' => 'required|min:5|max:450'
			
		);

		public function softwarelist()
		{
			return $this->hasMany('Softwarelist','softwaretype','type');
		}
}