<?php

class ItemsAjaxController extends \BaseController {

	public function getAllReceipt(){
		if(Request::ajax()){
			$id = $this->sanitizeString(Input::get('id'));
			if($id == -1){
				return json_encode('error');
			}else{
				$receipt = Receipt::where('inventory_id','=',$id)->select('number','id')->get();
				return $receipt;
			}
		}
	}

	//get all brands
	public function getItemBrands(){
		if(Request::ajax())
		{
			$itemtype = $this->sanitizeString(Input::get('itemtype'));
			if(count($itemtype) > 0){
				$brands = Inventory::where('itemtype_id',$itemtype)->select('brand')->get();
			}else{
				$brands = Inventory::select('brand')->get();
			}
			return json_encode($brands);
		}
	}

	//get all models
	public function getItemModels(){
		if(Request::ajax())
		{
			$brand = $this->sanitizeString(Input::get('brand'));
			if(count($brand) > 0){
				$models = Inventory::where('brand',$brand)->select('model')->get();
			}else{
				$models = Inventory::select('model')->get();
			}
			return json_encode($models);
		}
	}

	public function getPropertyNumberOnServer(){
		if(Request::ajax()){

			$model = $this->sanitizeString(Input::get('model'));
			$brand = $this->sanitizeString(Input::get('brand'));
			$itemtype = $this->sanitizeString(Input::get('itemtype'));
			if($model == '' || $brand == ''){
				return json_encode('');
			}

			$inventory = Inventory::where('model',$model)->where('brand',$brand)->where('itemtype_id',$itemtype)->select('id')->first();
			$propertynumber = Itemprofile::where('inventory_id',$inventory->id)->where('location','Server')->select('propertynumber')->get();

			if(count($brand) == 0  && count($itemtype) == 0){
				return json_encode('');
			}

			return json_encode($propertynumber);

		}
	}

	public function getUnassignedSystemUnit(){
		if(Request::ajax())
		{
			return Itemprofile::getUnassignedPropertyNumber('System Unit');
		}
	}

	public function getUnassignedMonitor(){
		if(Request::ajax())
		{
			return Itemprofile::getUnassignedPropertyNumber('Display');
		}
	}

	public function getUnassignedAVR(){
		if(Request::ajax())
		{
			return Itemprofile::getUnassignedPropertyNumber('AVR');
		}
	}

	public function getUnassignedKeyboard(){
		if(Request::ajax())
		{
			return Itemprofile::getUnassignedPropertyNumber('Keyboard');
		}
	}

	public function getAllPropertyNumber(){
		if(Request::ajax())
		{
			return json_encode(Itemprofile::lists('propertynumber'));
		}
	}

	public function getStatus($propertynumber){
		if(Request::ajax())
		{
			try{
				$item = Itemprofile::with('inventory.itemtype')
										->where('propertynumber','=',$propertynumber)
										->first();
				if(count($item) > 0) {
					return json_encode($item);
				} else {
					return json_encode('error');
				}
			} catch ( Exception $e ) {
				return json_encode('error');
			}
		}
	}

	public function getMonitorList()
	{
		if(Request::ajax())
		{
			$monitor = $this->sanitizeString(Input::get('term'));
			return json_encode(
				Itemprofile::unassembled()
							->whereHas('inventory',function($query){
								$query->whereHas('itemtype',function($query){
									$query->where('name','=','Display');
								});
							})
							->where('propertynumber','like','%'.$monitor.'%')
							->lists('propertynumber')
			);
		}
	}

	public function getKeyboardList()
	{
		if(Request::ajax())
		{
			$keyboard = $this->sanitizeString(Input::get('term'));
			return json_encode(
				Itemprofile::unassembled()
							->whereHas('inventory',function($query){
								$query->whereHas('itemtype',function($query){
									$query->where('name','=','Keyboard');
								});
							})
							->where('propertynumber','like','%'.$keyboard.'%')
							->lists('propertynumber')
			);
		}
	}

	public function getAVRList()
	{
		if(Request::ajax())
		{
			$avr = $this->sanitizeString(Input::get('term'));
			return json_encode(
				Itemprofile::unassembled()
							->whereHas('inventory',function($query){
								$query->whereHas('itemtype',function($query){
									$query->where('name','=','AVR');
								});
							})
							->where('propertynumber','like','%'.$avr.'%')
							->lists('propertynumber')
			);
		}
	}

	public function getSystemUnitList()
	{
		if(Request::ajax())
		{
			$systemunit = $this->sanitizeString(Input::get('term'));
			return json_encode(
				Itemprofile::unassembled()
							->whereHas('inventory',function($query){
								$query->whereHas('itemtype',function($query){
									$query->where('name','=','System Unit');
								});
							})
							->where('propertynumber','like','%'.$systemunit.'%')
							->lists('propertynumber')
			);
		}
	}

	public function checkifexisting($itemtype,$brand,$model)
	{
		$itemtype = $this->sanitizeString($itemtype);
		$brand = $this->sanitizeString($brand);
		$model = $this->sanitizeString($model);

		$inventory = Inventory::where('brand','=',$brand)
								->where('model','=',$model)
								->where('itemtype_id','=',$itemtype)
								->first();
								
		if(count($inventory) > 0)
		{
			return json_encode($inventory);
		} else {
			return json_encode('error');
		}
	}


}
