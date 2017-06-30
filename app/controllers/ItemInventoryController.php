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
					'data' => Inventory::select('id','itemtype_id','brand','model','details','warranty','unit','quantity','profileditems')->get()
					]);
		}

		$inventory = Inventory::select('id','itemtype_id','brand','model','details','warranty','unit','quantity','profileditems')->get();
		return View::make('inventory.item.index')
			->with('inventory',$inventory);
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

	public function add($id)
	{
		$inventory = Inventory::where('id',$id)->select('id','model','brand')->first();
		if(count($inventory) > 0)
		{
			return View::make('inventory.item.add')
				->with('inventory',$inventory);
		}else{
			Session::flash('error-message','System failure occurred');
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
		if(Input::get('action') == 'add')
		{
			$id = $this->sanitizeString(Input::get('id'));
			//receipt
			$number = $this->sanitizeString(Input::get('number'));
			$ponumber = $this->sanitizeString(Input::get('ponumber'));
			$podate = $this->sanitizeString(Input::get('podate'));
			$invoicedate = $this->sanitizeString(Input::get('invoicedate'));
			$invoicenumber = $this->sanitizeString(Input::get('invoicenumber'));
			$fundcode = $this->sanitizeString(Input::get('fundcode'));
			$quantity = $this->sanitizeString(Input::get('quantity'));

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
				return Redirect::to("inventory/item/$id/add")
					->withInput()
					->withErrors($validator);
			}

			try{

				$inventory = Inventory::find($id);
				$inventory->quantity = $inventory->quantity + $quantity;

				//receipt
				$receipt = new Receipt;
				$receipt->number = $number;
				$receipt->POno = $ponumber;
				$receipt->POdate = $podate;
				$receipt->invoiceno = $invoicenumber;
				$receipt->invoicedate = $invoicedate;
				$receipt->fundcode = $fundcode;
				$receipt->inventory_id = $inventory->id;
				$receipt->save();
				$inventory->save();
			} catch( Exception $e ){
				Session::flash('error-message','Error occurred on the server');
				return Redirect::to('inventory/item');
			}


			Session::flash('success-message','Items added to Inventory');
			return Redirect::to('inventory/item');
		}

		if(Input::get('action') == 'create')
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

			$inventory = Inventory::find($model);
			if(count($inventory) > 0){
				$inventory->quantity = $inventory->quantity + $quantity;
			}else{
				$inventory = new Inventory;
				//inventory
				$inventory->brand = $brand;
				$inventory->itemtype_id = $itemtype;
				$inventory->model = $model;
				$inventory->quantity = $quantity;
				$inventory->unit = $unit;
				$inventory->warranty = $warranty;
				$inventory->details = $details;
			}

			$inventory->save();

			//receipt
			$receipt = new Receipt;
			$receipt->number = $number;
			$receipt->POno = $ponumber;
			$receipt->POdate = $podate;
			$receipt->invoiceno = $invoicenumber;
			$receipt->invoicedate = $invoicedate;
			$receipt->fundcode = $fundcode;
			$receipt->inventory_id = $inventory->id;
			$receipt->save();

			Session::flash('success-message','Items added to Inventory');

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
		if(Request::ajax())
		{
			return json_encode(
					Inventory::where('id','=',$id)->select('id','itemtype_id','brand','model','details','warranty','unit','quantity','profileditems')->first()
					);
		}

		$items = Itemprofile::where('inventory_id','=',$id)->get();
		return View::make('inventory.item.show')
			->with('items',$items);
	}

}
