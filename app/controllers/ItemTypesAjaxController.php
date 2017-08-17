<?php

class ItemTypesAjaxController extends \BaseController {

	public function getAllItemTypes()
	{
		if(Request::ajax())
		{
			$workstation = Input::get('workstation');
			if($workstation === 'workstation'){
				$itemtype = Itemtype::where('name','!=','System Unit')
									->where('name','!=','Display')
									->where('name','!=','AVR')
									->where('name','!=','Keyboard')
									->get();
			}else{
				$itemtype = Itemtype::all();
			}
			return json_encode($itemtype);
		}
	}

	public function getAllFieldsFromGivenID($id)
	{
		$ret_val = "";
		if(Request::ajax())
		{
			try{
				$itemtype = Itemtype::find($id);
				$ret_val = explode(',',$itemtype->field);
			} catch (Exception $e) {
				$ret_val = "error";
			}

		}
			return json_encode($ret_val);
	}

	public function getItemTypesForEquipmentInventory()
	{
		if(Request::ajax())
		{
			$itemtype = Itemtype::where('category','=','equipment')->get();
			return json_encode($itemtype);
		}

	}

	public function getItemTypesForSuppliesInventory()
	{
		if(Request::ajax())
		{
			$itemtype = Itemtype::where('category','=','supply')->get();
			return json_encode($itemtype);
		}

	}


}
