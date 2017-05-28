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

			if($model == 'No record found' || $brand == 'No record found'){
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


}
