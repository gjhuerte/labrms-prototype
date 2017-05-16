<?php

use Carbon\Carbon;
class ItemsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('pagenotfound');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$id = $this->sanitizeString(Input::get('id'));
		$inventory = Inventory::find($id);
		return View::make('inventory.item.profile.create')
			->with('inventory',$inventory)
			->with('id',$id);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$inventory_id = $this->sanitizeString(Input::get('inventory_id'));
		$receipt_id = $this->sanitizeString(Input::get('receipt_id'));
		$property_number = $this->sanitizeString(Input::get('propertyid'));
		$serial_number = $this->sanitizeString(Input::get('serialid'));
		$location = $this->sanitizeString(Input::get('location'));
		$datereceived = $this->sanitizeString(Input::get('datereceived'));

		//validator
		$validator = Validator::make([
				'Property Number' => $property_number,
				'Serial Number' => $serial_number,
				'Location' => $location,
				'Date Received' => $datereceived,
				'Status' => 'working',
				'Location' => 'Server'
			],Itemprofile::$rules);

		if($validator->fails())
		{
			return Redirect::back()
				->withInput()
				->withErrors($validator);
		}else
		{

			$itemprofile = new Itemprofile;
			$itemprofile->propertynumber = $property_number;
			$itemprofile->serialnumber = $serial_number;
			$itemprofile->location = $location;
			$itemprofile->datereceived = Carbon::parse($datereceived);
			$itemprofile->status = 'working';
			$itemprofile->inventory_id = $inventory_id;
			$itemprofile->receipt_id = $receipt_id;
			$itemprofile->save();

			$inventory = Inventory::find($inventory_id);
			$inventory->profileditems = $inventory->profileditems + 1;
			$inventory->save();

			Session::flash('success-message','Item profiled');

			return Redirect::to('inventory/item');

		}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$itemprofile = Itemprofile::where('inventory_id','=',$id)->get();
		$inventory = Inventory::where('id','=',$id)->select('model')->first();
		return View::make('inventory.item.profile.index')
			->with('itemprofile',$itemprofile)
			->with('id',$inventory->model);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$item = Itemprofile::find($id);
		return View::make('inventory.item.profile.edit')
			->with('itemprofile',$item);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$receipt_id = $this->sanitizeString(Input::get('receipt_id'));
		$property_number = $this->sanitizeString(Input::get('propertyid'));
		$serial_number = $this->sanitizeString(Input::get('serialid'));
		$location = $this->sanitizeString(Input::get('location'));
		$datereceived = $this->sanitizeString(Input::get('datereceived'));

		//validator
		$validator = Validator::make([
				'Property Number' => $property_number,
				'Serial Number' => $serial_number,
				'Location' => $location,
				'Date Received' => $datereceived,
				'Status' => 'working',
				'Location' => 'Server'
			],Itemprofile::$updateRules);

		if($validator->fails())
		{
			return Redirect::back()
				->withInput()
				->withErrors($validator);
		}else
		{

			$itemprofile = Itemprofile::find($id);
			$itemprofile->propertynumber = $property_number;
			$itemprofile->serialnumber = $serial_number;
			$itemprofile->receipt_id = $receipt_id;
			$itemprofile->location = $location;
			$itemprofile->datereceived = Carbon::parse($datereceived);
			$itemprofile->save();

			Session::flash('success-message','Item updated');

			return Redirect::to('inventory/item');
		}
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$item = Itemprofile::find($id);
		$item->status = "condemn";
		$item->save();

		$inventory = Inventory::find($item->inventory_id);
		$inventory->quantity = $inventory->quantity - 1;
		$inventory->profileditems = $inventory->profileditems - 1;
		$inventory->save();

		$item = Itemprofile::find($id);
		$item->delete();

		Session::flash('success-message','Item removed from inventory');

		return Redirect::to('item/profile');
	}


	public function returnListOfReceipt(){
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
			if(isset($itemtype)){
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
			if(isset($brand)){
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
			$inventory = Inventory::where('model',$model)->where('brand',$brand)->where('itemtype_id',$itemtype)->select('id')->first();
			$propertynumber = Itemprofile::where('inventory_id',$inventory->id)->where('location','Server')->select('propertynumber')->get();

			return json_encode($propertynumber);
		}
	}

}
