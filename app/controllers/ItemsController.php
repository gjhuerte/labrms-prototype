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
		try {
			$id = $this->sanitizeString(Input::get('id'));
			$inventory = Inventory::find($id);
			return View::make('inventory.item.profile.create')
				->with('inventory',$inventory)
				->with('id',$id);

		} catch( Exception $e ) {
			return Redirect::to('inventory/item');
		}
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
		$location = $this->sanitizeString(Input::get('location'));
		$datereceived = $this->sanitizeString(Input::get('datereceived'));
		$propertynumber = "sample";
		$serialnumber = "sample";

		//validator
		$validator = Validator::make([
				'Property Number' => $propertynumber,
				'Serial Number' => $serialnumber,
				'Location' => $location,
				'Date Received' => $datereceived,
				'Status' => 'working',
				'Location' => 'Server'
			],Itemprofile::$rules);

		if($validator->fails())
		{
			return Redirect::to("item/profile/create?id=$inventory_id")
				->withInput()
				->withErrors($validator);
		}

		foreach(Input::get('item') as $item)
		{
			$propertynumber = $this->sanitizeString($item['propertynumber']);
			$serialnumber = $this->sanitizeString($item['serialid']);
			Itemprofile::data($propertynumber,$serialnumber,'Server',$datereceived,$inventory_id,$receipt_id);
			$details = "Equipment received and profiled on ".Carbon\Carbon::parse($datereceived)->toFormattedDateString();
			Ticket::generateTicket($propertynumber,'receive',$details,null,Auth::user()->id,null,'Closed');
		}

		Session::flash('success-message','Item profiled');
		return Redirect::to('inventory/item');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		if(Request::ajax()){

		 	return json_encode([
				'data' => Itemprofile::with('inventory')
									->where('inventory_id','=',$id)
									->get()
			]);
		}

		return View::make('inventory.item.profile.index')
								->with('id',$id);
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
		if(Request::ajax()){
			try{
				Inventory::condemn($id);
				return json_encode('success');
			} catch ( Exception $e ) {}
		}

		Inventory::condemn($item->inventory_id);
		Session::flash('success-message','Item removed from inventory');
		return Redirect::to('inventory/item');
	}

}
