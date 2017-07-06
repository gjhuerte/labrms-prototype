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

		$inventory = Inventory::where('brand','=',$brand)
					->where('model','=',$model)
					->where('itemtype','=',$itemtype)
					->first();

		if (count($inventory) > 0) {
			$inventory = Inventory::find($inventory->id);
			$inventory->quantity = $inventory->quantity;
			$inventory->save();
		} else {
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

	public function importView()
	{
		return View::make('inventory.item.import');
	}

	public function import()
	{
		Session::flash('success-message','Items Imported to Inventory');
		return Redirect::to('inventory/item/view/import');
	}

}
