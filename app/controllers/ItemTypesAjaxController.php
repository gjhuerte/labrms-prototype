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


}
