 <?php
class SupplyHistory extends Eloquent{
	//Database driver
	/*
		1 - Eloquent (MVC Driven)
		2 - DB (Directly query to SQL database, no model required)
	*/
	//The table in the database used by the model.


	//The table in the database used by the model.
	protected $table = 'supplyhistory';
	public $fillable = ['supply_id','unit','quantity','purpose','personinvolved'];
	public $timestamps = true;
	//Validation rules!
	
	public static $rules = array(
		'Unit' => 'required|alpha',
		'Quantity' => 'numeric',
		'Purpose' => 'required|min:2|max:100',
		'Person Involve' => 'required|min:5|max:1000'
	);

	public static $updateRules = array(
		'Unit' => 'alpha',
		'Quantity' => 'numeric',
		'Purpose' => 'min:2|max:100',
		'Person Involve' => 'min:5|max:1000'
	);

	public static function createRecord($supply_id,$quantity,$purpose,$name)
	{
		$history = new SupplyHistory;
		$history->supply_id = $supply_id;
		$history->quantity = $quantity;
		$history->remark = $purpose;
		$history->personinvolve = $name;
		$history->save();
	}

	/*
	*
	* Call this method when assigning to a workstation
	* @supply_id field must be validated before using on this method
	*
	*/
	public static function assignToWorkstationRecord($supply_id)
	{
		
		/*
		*
		*	The authenticated user
		*	
		*/
		$name = Auth::user()->firstname . " " . Auth::user()->middlename . " " . Auth::user()->lastname;
		$purpose = 'Assigned to  a workstation';

		/*
		*
		* Create a supply history based on the supply id used
		* Supply ID must be validated before using on this form
		* The person involved is the one who assembled the workstation
		* Purpose is predefined and static
		*
		*/
		$history = new SupplyHistory;
		$history->supply_id = $supply_id;
		$history->quantity = 1;
		$history->remark = $purpose;
		$history->personinvolve = $name;
		$history->save();
	}
}
