<?php

class SuppliesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if(Request::ajax())
		{
			return json_encode([
					'data' => Supply::with('itemtype')->get()
				]);
		}
		
		return View::make('inventory.supplies.index');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('inventory.supplies.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$brand = $this->sanitizeString(Input::get('brand'));
		$itemtype = $this->sanitizeString(Input::get('itemtype'));
		$unit = $this->sanitizeString(Input::get('unit'));
		$quantity = $this->sanitizeString(Input::get('quantity'));

		$validator = Validator::make([
				'Brand' => $brand,
				'Item Type' => $itemtype,
				'Unit' => $unit,
				'Quantity' => $quantity
			],Supply::$rules);

		if($validator->fails())
		{
			return Redirect::to('supplies/create')
					->withInput()
					->withErrors($validator);
		}

		try{
			$supply = Supply::where('brand','=',$brand)->first();
			$supply->quantity = $supply->quantity + $quantity;
			$supply->save();
		} catch(Exception $e){

			$supply = new Supply;
			$supply->quantity = $quantity;
			$supply->brand = $brand;
			$supply->itemtype_id = $itemtype;
			$supply->unit = $unit;
			$supply->save();

		}

		Session::flash('success-message','Supplies added');
		return Redirect::to('supplies');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		try{

			$supplyhistory = SupplyHistory::where('supply_id','=',$id)->get();
			return View::make('inventory.supplies.show')
						->with('supplyhistory',$supplyhistory)
						->with('supply',Supply::with('itemtype')->find($id));
		} catch(Exception $e){
			return Redirect::to('supplies');
		}
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$supply = Supply::find($id);
		return View::make('inventory.supplies.edit')
			->with('supply',$supply);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$brand = $this->sanitizeString(Input::get('brand'));
		$itemtype = $this->sanitizeString(Input::get('itemtype'));
		$unit = $this->sanitizeString(Input::get('unit'));

		$validator = Validator::make([
				'brand' => $brand,
				'itemtype' => $itemtype,
				'unit' => $unit,
				'quantity' => 0
			],Supply::$updateRules);

		if($validator->fails())
		{
			return Redirect::to("supplies/$id/edit")
				->withInput()
				->withErrors($validator);
		}

		try{
		
			$supply = Supply::find($id);
			$supply->brand = $brand;
			$supply->itemtype_id = $itemtype;
			$supply->unit = $unit;
			$supply->save();

		} catch( Exception $e){
			Session::flash('error-message','Problem occurs while processing your request');
			return Redirect::to('supplies');
		}

		Session::flash('success-message','Supplies Information has been updated');	
		return Redirect::to('supplies');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		/*
		*
		*	Supply ajax request
		*	
		*
		*/
		if(Request::ajax())
		{
			$id = $this->sanitizeString(Input::get('id'));
			$quantity = $this->sanitizeString(Input::get('quantity'));
			$supplies = Supplies::find($id);
			$supplies->quantity = $supplies->quantity - $quantity;
			$supplies->save();
		}

		/*
		*
		*	
		*	
		*
		*/
		$id = $this->sanitizeString(Input::get('id'));
		$quantity = $this->sanitizeString(Input::get('quantity'));
		$name = $this->sanitizeString(Input::get('name'));
		$purpose = $this->sanitizeString(Input::get('purpose'));

		try{
			Supply::release($id,$quantity,$purpose,$name);
			Session::flash('success-message',"$quantity supplies has been consumed");
			return Redirect::to('supplies');
		} catch ( Exception $e ) {

			Session::flash('error-message',"Problem encountered while processing your request");
			return Redirect::to('supplies');
		}
	}

	function getSupplyInformation($itemtype,$brand)
	{
		if(Request::ajax()){

			$itemtype = $this->sanitizeString($itemtype);
			$brand = $this->sanitizeString($brand);

			$supply = Supply::where('itemtype_id','=',$itemtype)
							->where('brand','=',$brand)
							->first();

			if(count($supply) > 0) return json_encode($supply);
			else  return json_encode('error');

		}
	}

	function getBrandList()
	{
		if(Request::ajax())
		{
			$brand = $this->sanitizeString(Input::get("term"));

			return json_encode(
				Supply::where('brand','like','%'.$brand.'%')->distinct()->lists('brand')
			);
		}
	}


}
