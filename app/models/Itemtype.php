 <?php
 use Illuminate\Database\Eloquent\SoftDeletingTrait;
class Itemtype extends Eloquent{
		use SoftDeletingTrait;
	//Database driver
		/*
			1 - Eloquent (MVC Driven)
			2 - DB (Directly query to SQL database, no model required)
		*/

		//The table in the database used by the model.
		protected $table = 'itemtype';
		protected $dates = ['deleted_at'];

		//The attribute that used as primary key.
		protected $primaryKey = 'type';
		public $timestamps = false;
		public $fillable = ['type','description'];
		//Validation rules!
		public static $rules = array(
			'type' => 'required|min:2|max:50|unique:itemtype,type',
			'description' => 'required|min:5|max:450'
		);

		public static $updateRules = array(
			'type' => 'required|min:2|max:50',
			'description' => 'required|min:5|max:450'
		);

		public function verifyItemTypes($item,$array)
		{
			foreach($array as $data)
			{
				if($item == $data)
				{
					return true;
				}
			}

			return false;

		}
}