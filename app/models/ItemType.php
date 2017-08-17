 <?php

class ItemType extends Eloquent{
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
	protected $primaryKey = 'id';
	public $timestamps = true;
	public $fillable = ['name','description','category'];
	//Validation rules!
	public static $rules = array(
		'name' => 'required|min:2|max:50|unique:itemtype,name',
		'description' => 'required|min:5|max:450'
	);

	public static $updateRules = array(
		'name' => 'min:2|max:50',
		'description' => 'min:5|max:450'
	);

	/**
	*
	*	@param $type accepts the type name
	*	usage: ItemType::type('System Unit')->get();
	*
	*/
    public function scopeType($query,$type)
    {
    	return $query->where('name','=',$type);
    }

    /**
    *
    *	saves record to database
    *	@param $name
    *	@param $description
    *	@param $category
    *	@return item type details
    *
    */
    public static function createRecord($name,$description,$category)
    {
    	DB::transaction(function() use ($name,$description,$category)
    	{
			$itemtype = new ItemType;
			$itemtype->name = $name;
			$itemtype->description = $description;
			$itemtype->category = $category;
			$itemtype->save();
			return $itemtype;
    	});
    }
}
