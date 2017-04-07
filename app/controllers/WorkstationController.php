<?php

class WorkstationController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$workstations = Pc::all();
		return View::make('workstation.index')
			->with('workstations',$workstations);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('workstation.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

		if(Input::get('create') == 'Create')
		{
			$name = Input::get('name');
			$mr_no = Input::get('mrno');
			$systemunit_property = Input::get('systemunitproperty');
			$systemunit_serialid = Input::get('systemunitserialid');
			$display_property = Input::get('displayproperty');
			$display_serial = Input::get('displayserialid');
			$keyboard = ((Input::get('keyboard') == 'keyboard')  ? '1' : '0');
			$mouse = ((Input::get('mouse') == 'mouse') ? '1' : '0');
			$description = 'Workstation part';

			$validator = Validator::make([
					'name' => Input::get('systemunitname'),
					'system unit serial id' => $systemunit_serialid,
					'system unit property number' => $systemunit_property,
					'MR number' => $mr_no,
					'description' => 'Workstation part',
					'status' => 'working',
					'location' => 'Server'
				],ItemprofileSystemunit::$rules);

			if($validator->fails())
			{
				return Redirect::to('workstation/create')
					->withInput()
					->withErrors($validator);
			}

			$validator = Validator::make([
					'name' => Input::get('systemunitname'),
					'display serial id' => $display_serial,
					'display property number' => $display_property,
					'MR number' => $mr_no,
					'description' => 'Workstation part',
					'status' => 'working',
					'location' => 'Server'
				],ItemprofileDisplay::$rules);

			if($validator->fails())
			{
				return Redirect::to('workstation/create')
					->withInput()
					->withErrors($validator);
			}


			$validator = Validator::make([
					'name' => $name,
					'keyboard' => $keyboard,
					'mouse' => $mouse
				],Pc::$rules);

			if($validator->fails())
			{
				return Redirect::to('workstation/create')
					->withInput()
					->withErrors($validator);
			}

			$inventory = Inventory::where('itemname','=',Input::get('systemunitname'))->first();
			if(empty($inventory))
			{
				$inventory = Inventory::create([
						'itemname' => Input::get('systemunitname'),
						'quantity' => '0',
						'added' => '0',
						'adjust' => '0',
						'deduct' => '0',
						'total' => '0'
					]);
			}


			$systemunit = new Itemprofile;
			$systemunit->serialid = $systemunit_serialid;
			$systemunit->property_number = $systemunit_property;
			$systemunit->type = 'System Unit';
			$systemunit->MR_no = $mr_no;
			$systemunit->description = $description;
			$systemunit->status = 'working';
			$systemunit->location = 'Server';
			$systemunit->inventory_id = $inventory->id;
			$systemunit->save();

			$inventory->increaseInventoryQuantity($inventory->id);


			$inventory = Inventory::where('itemname','=',Input::get('displayname'))->first();
			if(empty($inventory))
			{
				$inventory = Inventory::create([
						'itemname' => Input::get('displayname'),
						'quantity' => '0',
						'added' => '0',
						'adjust' => '0',
						'deduct' => '0',
						'total' => '0'
					]);
			}

			$display = new Itemprofile;
			$display->serialid = $display_serial;
			$display->property_number = $display_property;
			$display->type = 'Display';
			$display->MR_no = $mr_no;
			$display->description = $description;
			$display->status = 'working';
			$display->location = 'Server';
			$display->inventory_id = $inventory->id;
			$display->save();

			$inventory->increaseInventoryQuantity($inventory->id);

			$pc = new Pc;
			$pc->name = Input::get('name');
			$pc->systemunit_id = $systemunit->id;
			$pc->display_id = $display->id;
			$pc->keyboard = $keyboard;
			$pc->mouse = $mouse;
			$pc->save();


			//create a ticket
			$ticket = Ticket::create([
				'title' => 'Received items',
				'description' => 'System unit for workstation',
				'type' => 'receive',
				'clientname' => Auth::user()->username
			]); 

			$ticket = Ticket::find($ticket->id);
			$itemprofile = Itemprofile::find($systemunit->id);
			$ticket->itemprofile()->associate($itemprofile);
			$ticket->save();


			//create a ticket
			$ticket = Ticket::create([
				'title' => 'Received items',
				'description' => 'Display for workstation',
				'type' => 'receive',
				'clientname' => Auth::user()->username
			]); 

			$ticket = Ticket::find($ticket->id);
			$itemprofile = Itemprofile::find($display->id);
			$ticket->itemprofile()->associate($itemprofile);
			$ticket->save();

			Session::flash('success-message','Workstation created');
			return Redirect::to('workstation');

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
		$pc = Pc::find($id);
		return View::make('workstation.show')
			->with('pc',$pc);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$workstation = Pc::find($id);
		$display = Itemprofile::where('location','=','Server')
			->where('type','=','Display')
			->get();
		return View::make('workstation.edit')
			->with('workstation',$workstation)
			->with('monitors',$display);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		if(Input::get('update') == 'Update')
		{
			$name = Input::get('name');
			$display = Input::get('display');
			$keyboard = ((Input::get('keyboard') == 'keyboard')  ? '1' : '0');
			$mouse = ((Input::get('mouse') == 'mouse') ? '1' : '0');
			$description = 'Workstation '.$name;

			$validator = Validator::make([
					'name' => $name,
					'keyboard' => $keyboard,
					'mouse' => $mouse
				],Pc::$rules);

			if($validator->fails())
			{
				return Redirect::to("workstation/$id/edit")
					->withInput()
					->withErrors($validator);
			}

			$pc = Pc::find($id);
			$pc->name = Input::get('name');
			$itemprofile = Itemprofile::find($display);
			$pc->display()->associate($itemprofile);
			$pc->keyboard = $keyboard;
			$pc->mouse = $mouse;
			$pc->save();

			//create a ticket
			$ticket = Ticket::create([
				'title' => 'Update item information',
				'description' => 'Update workstation '.$name.' display',
				'type' => 'maintenance',
				'clientname' => Auth::user()->username
			]); 

			$ticket = Ticket::find($ticket->id);
			$ticket->itemprofile()->associate($itemprofile);
			$ticket->save();

			Session::flash('success-message','Workstation information updated');
			return Redirect::to('workstation');

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
		$pc = Pc::find($id);
		$inventory = new Inventory;
		$itemprofile = new Itemprofile;

		if( count($pc->systemunit->inventory) > 0 ){
			$inventory->decreaseInventoryQuantity($pc->systemunit->inventory->id);
			$itemprofile->setItemAsCondemned($pc->systemunit->inventory->id);
		}

		if( count($pc->display->inventory) ){
			$itemprofile->setItemAsCondemned($pc->display->inventory->id);
			$inventory->decreaseInventoryQuantity($pc->display->inventory->id);
		}

		if( count($pc->systemunit) ){
			$item = Itemprofile::find($pc->systemunit->id);
			$ticket = new Ticket;
			$ticket->generateCondemnTicket($item->property_number,$item);
			$item->status = "condemn";
			$item->save();	

			$item = Itemprofile::find($pc->systemunit->id);
			$item->delete();
		}

		if( count($pc->display) ){

			$item = Itemprofile::find($pc->display->id);
			$ticket = new Ticket;
			$ticket->generateCondemnTicket($item->property_number,$item);
			$item->status = "condemn";
			$item->save();

			$item = Itemprofile::find($pc->display->id);
			$item->delete();

		}

		$pc = Pc::find($id);
		$pc->delete();

		Session::flash('success-message','Workstation condemned');
		return Redirect::to('workstation');
	}



}
