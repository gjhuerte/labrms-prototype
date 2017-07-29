<?php

class ItemInventoryController extends \BaseController {

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
					'data' => Inventory::with('itemtype')
									->select('id','itemtype_id','brand','model','details','warranty','unit','quantity','profileditems')
									->get()
					]);
		}

		return View::make('inventory.item.index');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('inventory.item.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//receipt
		$number = $this->sanitizeString(Input::get('number'));
		$ponumber = $this->sanitizeString(Input::get('ponumber'));
		$podate = $this->sanitizeString(Input::get('podate'));
		$invoicedate = $this->sanitizeString(Input::get('invoicedate'));
		$invoicenumber = $this->sanitizeString(Input::get('invoicenumber'));
		$fundcode = $this->sanitizeString(Input::get('fundcode'));

		$validator = Validator::make([
				'Acknowledgement Receipt' => $number,
				'P.O. Number' => $ponumber,
				'P.O. Date' => $podate,
				'Invoice Number' => $invoicenumber,
				'Invoice Date' => $invoicedate,
				'Fund Code' => $fundcode
			],Receipt::$rules);

		if($validator->fails())
		{
			return Redirect::to('inventory/item/create')
				->withInput()
				->withErrors($validator);
		}

		//inventory
		$brand = $this->sanitizeString(Input::get('brand'));
		$itemtype = $this->sanitizeString(Input::get('itemtype'));
		$model = $this->sanitizeString(Input::get('model'));
		$quantity = $this->sanitizeString(Input::get('quantity'));
		$unit = $this->sanitizeString(Input::get('unit'));
		$warranty = $this->sanitizeString(Input::get('warranty'));
		$details = $this->sanitizeString(Input::get('details'));

		//validator
		$validator = Validator::make([
				'Item Type' => $itemtype,
				'Brand' => $brand,
				'Model' => $model,
				'Details' => $details,
				'Warranty' => $warranty,
				'Unit' => $unit,
				'Quantity' => $quantity,
				'Profiled Items' => 0
			],Inventory::$rules);

		if($validator->fails())
		{
			return Redirect::to('inventory/item/create')
				->withInput()
				->withErrors($validator);
		}

		try {

			$inventory = Inventory::where('brand','=',$brand)
						->where('model','=',$model)
						->where('itemtype','=',$itemtype)
						->where('details', '=', $details)
						->first();

			$inventory->quantity = $inventory->quantity + $quantity;
			$inventory->save();
		} catch(Exception $e) {
			Inventory::data([
				'brand' => $brand,
				'itemtype' => $itemtype,
				'model' => $model,
				'quantity' => $quantity,
				'unit' => $unit,
				'warranty' => $warranty,
				'details' => $details
			],[
				'number' => $number,
				'ponumber' => $ponumber,
				'podate' => $podate,
				'invoicenumber' => $invoicenumber,
				'invoicedate' => $invoicedate,
				'fundcode' => $fundcode
			]);
		}

		Session::flash('success-message','Items added to Inventory');
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
		if(Request::ajax())
		{
			return json_encode(
				Inventory::where('id','=',$id)
								->with('itemtype')
								->select('id','itemtype_id','brand','model','details','warranty','unit','quantity','profileditems')
								->first()
					);
		}

		return View::make('inventory.item.show');
	}

	public function edit($id)
	{
		try{
			$inventory = Inventory::find($id);
			return View::make('inventory.item.edit')
					->with('inventory',$inventory);
		} catch ( Exception $e ) {
			Session::flash('success-message','Problems occur while sending your data to the server');
			return Redirect::to('inventory/item');
		}
	}

	public function update($id)
	{

		//inventory
		$brand = $this->sanitizeString(Input::get('brand'));
		$itemtype = $this->sanitizeString(Input::get('itemtype'));
		$model = $this->sanitizeString(Input::get('model'));
		$unit = $this->sanitizeString(Input::get('unit'));
		$warranty = $this->sanitizeString(Input::get('warranty'));
		$details = $this->sanitizeString(Input::get('details'));

		//validator
		$validator = Validator::make([
				'Item Type' => $itemtype,
				'Brand' => $brand,
				'Model' => $model,
				'Details' => $details,
				'Warranty' => $warranty,
				'Unit' => $unit,
				'Quantity' => 0,
				'Profiled Items' => 0
			],Inventory::$rules);

		if($validator->fails())
		{
			return Redirect::to("inventory/item/$id/edit")
				->withInput()
				->withErrors($validator);
		}

		try {

			$inventory = Inventory::find($id);
			$inventory->brand = $brand;
			$inventory->model = $model;
			$inventory->itemtype_id = $itemtype;
			$inventory->details = $details;
			$inventory->warranty = $warranty;
			$inventory->unit = $unit;
			$inventory->save();
		} catch(Exception $e) {
			Session::flash('error-message','Unknown Error Encountered');
			return Redirect::to('inventory/item');
		}

		Session::flash('success-message','Inventory content updated');
		return Redirect::to('inventory/item');

	}

	public function importView()
	{
		return View::make('inventory.item.import');
	}

	public function import()
	{
		$file = Input::file('file');
		// $filename = str_random(12);
		//$filename = $file->getClientOriginalName();
		//$extension =$file->getClientOriginalExtension();
		$filename = 'inventory.'.$file->getClientOriginalExtension();
		$destinationPath = public_path() . '\files';
		$file->move($destinationPath, $filename);

		$excel = Excel::load($destinationPath . "/" . $filename, function($reader) {

		    // reader methods

		})->get();


		return $excel;
		Session::flash('success-message','Items Imported to Inventory');
		return Redirect::to('inventory/item/view/import');
	}

	public function getBrands()
	{
		if(Request::ajax())
		{
			$brand = $this->sanitizeString(Input::get('term'));
			return json_encode(
				Inventory::where('brand','like','%'.$brand.'%')->lists('brand')
			);
		}
	}

	public function getModels()
	{
		if(Request::ajax())
		{
			$model = $this->sanitizeString(Input::get('term'));
			return json_encode(
				Inventory::where('model','like','%'.$model.'%')->lists('model')
			);
		}
	}

}
