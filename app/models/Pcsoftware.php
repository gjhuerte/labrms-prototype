 <?php
 use Illuminate\Database\Eloquent\SoftDeletingTrait;
class Pcsoftware extends Eloquent{
		use SoftDeletingTrait;
	//Database driver
		/*
			1 - Eloquent (MVC Driven)
			2 - DB (Directly query to SQL database, no model required)
		*/

		//The table in the database used by the model.
		protected $table = 'pcsoftware';
		protected $dates = ['deleted_at'];
		public $timestamps = true;
		public $fillable = ['pc_id','software_id'];
		//Validation rules!
		public static $rules = array(
			'workstation' => 'required|exists:pc,id',
			'software' => 'required|exists:softwarelist,id'
		);

		public static $updateRules = array(
			'workstation' => 'required|exists:pc,id',
			'software' => 'required|exists:softwarelist,id'
		);

		public function pc()
		{
			return $this->belongsTo('Pc','pc_id','id');
		}

		public function softwarelist()
		{
			return $this->belongsTo('Softwarelist','software_id','id');
		}
}