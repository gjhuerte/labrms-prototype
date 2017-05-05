<?php

class ItemInventoryController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$inventory = Inventory::all();
		return View::make('inventory.item.index')
			->with('inventorydetails',$inventory);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		// $itemname = $this->sanitizeString(Input::get('itemname'));
		// $itemtype = $this->sanitizeString(Input::get('itemtype'));
		// return View::make('inventory.create')
		// 	->with('itemname',$itemname)
		// 	->with('itemtype',$itemtype);

		return View::make('inventory.multiple-item.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		return Input::all();
		$itemname = $this->sanitizeString(Input::get('itemname'));
		$serialid = $this->sanitizeString(Input::get('serialid'));
		$property_number = $this->sanitizeString(Input::get('propertyid'));
		$MR_no = $this->sanitizeString(Input::get('MR_no'));
		$description = $this->sanitizeString(Input::get('description'));

		//validator
		$validator = Validator::make([
				'name' => $itemname,
				'serial id' => $serialid,
				'property number' => $property_number,
				'MR number' => $MR_no,
				'description' => $description,
				'status' => 'working',
				'location' => 'Server'
			],Itemprofile::$rules);

		if($validator->fails())
		{
			return Redirect::to('item/profile/create')
				->withInput()
				->withErrors($validator);
		}else
		{
			$inventory = Inventory::where('itemname','=',$itemname)->first();
			if(empty($inventory))
			{
				$inventory = Inventory::create([
						'itemname' => Input::get('itemname'),
						'quantity' => '0',
						'added' => '0',
						'adjust' => '0',
						'deduct' => '0',
						'total' => '0'
					]);
			}

			$item = new Itemprofile;
			$item->serialid = Input::get('serialid');
			$item->property_number = Input::get('propertyid');
			$item->type = Input::get('type');
			$item->MR_no = Input::get('MR_no');
			$item->description = '"'.Input::get('description').'"';
			$item->status = 'working';
			$item->location = 'Server';
			$item->inventory()->associate($inventory);
			$item->save();

			$inventory->increaseInventoryQuantity($inventory->id);
				
			$ticket = new Ticket;
			$item = Itemprofile::where('property_number','=',$property_number)->first();
			$ticket->generateReceiveTicket($description,$item->id);

			Session::flash('success-message','Item added to inventory');

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
		$items = Itemprofile::where('inventory_id','=',$id)->get();
		return View::make('inventory.item.show')
			->with('items',$items);
	}

	public function getItemField()
	{
		if(Request::ajax())
		{
			if(is_numeric(Input::get('quantity')))
			{
				$quantity = Input::get('quantity');
				$output = "";
				for($ctr = 1;$ctr<=$quantity;$ctr++)
				{
					$output .= "<div class='form-group'>
									<div class='col-sm-12'>
									<label>Item #".$ctr."</label>
									</div>
									<div class='col-sm-6'>
									<input class='form-control' placeholder='Serial ID' name='serialid".$ctr."' type='text' id='serialid'>
									</div>		

									<div class='col-sm-6'>
									<input class='form-control' placeholder='Property Number' name='propertyid".$ctr."' type='text' id='propertyid'>
									</div>
								</div>";
				}
				return $output;

			}
		}
	}


}
