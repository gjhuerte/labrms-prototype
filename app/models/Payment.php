 <?php
 use Illuminate\Database\Eloquent\SoftDeletingTrait;
class Payment extends Eloquent{
		use SoftDeletingTrait;
	//Database driver
		/*
			1 - Eloquent (MVC Driven)
			2 - DB (Directly query to SQL database, no model required)
		*/

		//The table in the database used by the model.
		protected $table = 'payment';
		protected $dates = ['deleted_at'];
		public $timestamps = false;
		public $fillable = ['amount','received_by'];
		//Validation rules!
		public static $rules = array(
			'amount' => 'required|numeric',
			'received_by' => 'required'
		);

		public static $updateRules = array(
		);
}