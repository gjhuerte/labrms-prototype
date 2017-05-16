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

	public function getIDFromPropertyNumber($propertynumber)
	{
		$item = Itemprofile::where('propertynumber',$propertynumber)->select('id')->first();
		return $item->id;
	}

	//validates if the said $item is equal to the $type
	//fetch the type the item belongs to
	//returns a boolean record
	public function checkIfTypeIsValid($item,$type)
	{
		if($item->inventory->itemtype->name == $type)
		{
			return true;
		}else {
			return false;
		}
	}

}
