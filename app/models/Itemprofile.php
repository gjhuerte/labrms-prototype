 <?php

 use Illuminate\Database\Eloquent\SoftDeletingTrait;
class Itemprofile extends Eloquent{
		use SoftDeletingTrait;
	//Database driver
		/*
			1 - Eloquent (MVC Driven)
			2 - DB (Directly query to SQL database, no model required)
		*/

		//The table in the database used by the model.
		protected $table = 'itemprofile';
		protected $dates = ['deleted_at'];
		public $timestamps = true;
		public $fillable = ['serialid','type','property_number','MR_no','status','description','location'];
		//Validation rules!
		public static $rules = array(
			'serial id' => 'min:5|max:100|unique:itemprofile,serialid',
			'property number' => 'required|min:5|max:100|unique:itemprofile,property_number',
			'MR number' =>'required|min:5|max:50',
			'status' =>'required|min:5|max:50',
			'description' =>'required|min:5|max:100',
			'location' =>'required|min:5|max:100'
		);

		public static $updateRules = array(
			'serial id' => 'min:5|max:100',
			'property number' => 'required|min:5|max:100',
			'MR number' =>'required|min:5|max:50',
			'status' =>'required|min:5|max:50',
			'description' =>'required|min:5|max:100',
			'location' =>'required|min:3|max:100'
		);

		public function setItemAsCondemned($id)
		{
			$itemprofile = Itemprofile::find($id);
			$itemprofile->status = 'condemn';
			$itemprofile->location = 'Property Office';
			$itemprofile->save();
		}

		public function inventory()
		{
			return $this->belongsTo('Inventory','inventory_id','id');
		}

		public function roominventory()
		{
			return $this->hasMany('Roominventory','item_id','id');
		}

		public function ticket()
		{
			return $this->HasMany('Ticket','item_id','id');
		}

		public function itemtype()
		{
			return $this->belongsTo('Itemtype','type','type');
		}

		public function reservation()
		{
			return $this->hasOne('Reservation','item_id','id');
		}

		public function user()
		{
			return $this->belongsToMany('User','Reservation','item_id','user_id');
		}
}