<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	public	function sanitizeString($var)
	{
		$var = strip_tags($var);
		$var = htmlentities($var);
		$var = stripslashes($var);
		return $var;
	}

	public function hasData($input)
	{
		if($input == null || empty($input) || $input == "")
			return false;
		return true;
	}

	//accepts a property Number
	//returns the ID of the property number
	public function get_id_from_property_number($propertynumber)
	{
		$item = Itemprofile::where('propertynumber',$propertynumber)->select('id')->first();
		if(count($item) > 0){
			return $item->id;
		}
		else {
			return null;
		}
	}

	//validates if the said $item is equal to the $type
	//fetch the type the item belongs to
	//returns a boolean record
	public function check_if_correct_type($item,$type)
	{
		$item = Itemprofile::find($item);

		if(!$item)
		{
			return false;
		}

		switch($item->inventory->itemtype->name){
			case $type:
				return true;
			default:
				return false;
		}
	}

}
