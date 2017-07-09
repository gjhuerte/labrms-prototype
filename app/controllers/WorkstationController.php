<?php

class WorkstationController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if(Request::ajax())
		{
			return json_encode(['data'=> Pc::with('keyboard','avr','monitor','systemunit.roominventory.room')->get()]);
		}

		return View::make('workstation.index');
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
		// return Input::all();

		/*
		*
		*  Initiate all values
		*
		*/

		//workstations

		//receipt

		$mrnumber = $this->sanitizeString(Input::get('mrnumber'));
		$ponumber = $this->sanitizeString(Input::get('ponumber'));
		$podate = $this->sanitizeString(Input::get('podate'));
		$invoicenumber = $this->sanitizeString(Input::get('invoicenumber'));
		$invoicedate = $this->sanitizeString(Input::get('invoicedate'));
		$fundcode = $this->sanitizeString(Input::get('fundcode'));

		//inventory
		$systemunit_specification = $this->sanitizeString(Input::get('systemunit_specification'));
		$monitor_specification = $this->sanitizeString(Input::get('monitor_specification'));
		$systemunit_brand = $this->sanitizeString(Input::get('systemunit_brand'));
		$monitor_brand = $this->sanitizeString(Input::get('monitor_brand'));
		$systemunit_model = $this->sanitizeString(Input::get('systemunit_model'));
		$monitor_model = $this->sanitizeString(Input::get('monitor_model'));

		/*
		*
		*  Validate
		*
		*/

		/*
		*
		*  Send to database
		*
		*/
		
		// Inventory
		$sys_itemtype = Itemtype::where('name','=','System Unit')->first();
		$systemunit_inventory = new Inventory;
		$systemunit_inventory->brand = $systemunit_brand;
		$systemunit_inventory->model = $systemunit_model;
		$systemunit_inventory->unit = 'Set'; 	
		$systemunit_inventory->details = $systemunit_specification;
		$systemunit_inventory->itemtype_id = $sys_itemtype->id;
		$systemunit_inventory->profileditems = count(Input::get('workstation'));
		$systemunit_inventory->quantity = count(Input::get('workstation'));
		$systemunit_inventory->save();

		$mon_itemtype = Itemtype::where('name','=','Display')->first();
		$monitor_inventory = new Inventory;
		$monitor_inventory->brand = $monitor_brand;
		$monitor_inventory->model = $monitor_model;
		$monitor_inventory->unit = 'Set';
		$monitor_inventory->details = $monitor_specification;
		$monitor_inventory->itemtype_id = $mon_itemtype->id;
		$monitor_inventory->profileditems = count(Input::get('workstation'));
		$monitor_inventory->quantity = count(Input::get('workstation'));
		$monitor_inventory->save();

		// Receipt
		$systemunit_receipt = new Receipt;
		$systemunit_receipt->number = $mrnumber;
		$systemunit_receipt->inventory_id = $systemunit_inventory->id;
		$systemunit_receipt->pono = $ponumber;
		$systemunit_receipt->podate = $podate;
		$systemunit_receipt->invoiceno = $invoicenumber;
		$systemunit_invoicedate = $invoicedate;
		$systemunit_receipt->fundcode = $fundcode;
		$systemunit_receipt->save();

		$monitor_receipt = new Receipt;
		$monitor_receipt->number = $mrnumber;
		$monitor_receipt->inventory_id = $monitor_inventory->id;
		$monitor_receipt->pono = $ponumber;
		$monitor_receipt->podate = $podate;
		$monitor_receipt->invoiceno = $invoicenumber;
		$monitor_invoicedate = $invoicedate;
		$monitor_receipt->fundcode = $fundcode;
		$monitor_receipt->save();

		//workstations
		foreach(Input::get('workstation') as $workstation)
		{
			$systemunit_itemprofile = new Itemprofile;
			$systemunit_itemprofile->propertynumber =  $this->sanitizeString($workstation['systemunit']['propertynumber']);
			$systemunit_itemprofile->serialnumber = $this->sanitizeString($workstation['systemunit']['serialid']);
			$systemunit_itemprofile->location = 'Server';
			$systemunit_itemprofile->datereceived = Carbon\Carbon::now();
			$systemunit_itemprofile->status = 'working';
			$systemunit_itemprofile->inventory_id = $systemunit_inventory->id;
			$systemunit_itemprofile->receipt_id = $systemunit_receipt->id;
			$systemunit_itemprofile->save();

			$server = Room::where('name','=','Server')->first();

			$roominventory = Roominventory::create([
					'item_id' => $systemunit_itemprofile->id,
					'room_id' => $server->id
				]);

			$monitor_itemprofile = new Itemprofile;
			$monitor_itemprofile->propertynumber =  $this->sanitizeString($workstation['monitor']['propertynumber']);
			$monitor_itemprofile->serialnumber = $this->sanitizeString($workstation['monitor']['serialid']);
			$monitor_itemprofile->location = 'Server';
			$monitor_itemprofile->datereceived = Carbon\Carbon::now();
			$monitor_itemprofile->status = 'working';
			$monitor_itemprofile->inventory_id = $monitor_inventory->id;
			$monitor_itemprofile->receipt_id = $monitor_receipt->id;
			$monitor_itemprofile->save();

			$roominventory = Roominventory::create([
					'item_id' => $monitor_itemprofile->id,
					'room_id' => $server->id
				]);

			$pc = new Pc;
			$pc->systemunit_id = $systemunit_itemprofile->id;
			$pc->monitor_id = $monitor_itemprofile->id;
			$pc->save();
		}

		Session::flash('success-message','Workstation created');
		return Redirect::to('workstation');
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
		$pc = Pc::where('id','=',$id)
					->with('keyboard','avr','monitor','systemunit.roominventory.room')
					->first();

		return View::make('workstation.edit')
			->with('pc',$pc);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$avr = $this->sanitizeString(Input::get('avr'));
		$monitor = $this->sanitizeString(Input::get('monitor'));
		$systemunit = $this->sanitizeString(Input::get('systemunit'));
		$os = $this->sanitizeString(Input::get('os'));
		$keyboard = $this->sanitizeString(Input::get('keyboard'));
		$mouse = $this->sanitizeString(Input::get('mouse'));

		$validator = Validator::make([
		  'Operating System Key' => $os
		],Pc::$updateRules);

		if($validator->fails())
		{
		  return Redirect::to("workstation/$id/edit")
		    ->withInput()
		    ->withErrors($validator);
		}

		$pc = Pc::find($id);
		$pc->oskey = $os;
		$pc->mouse = $mouse;

		$pc->save();

		Session::flash('success-message','Workstation information updated');
		return Redirect::to('workstation');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if(Request::ajax())
		{
			$pc = $this->sanitizeString(Input::get('selected'));
			foreach( Pc::separateArray($pc) as $pc )
			{
				try{
					$pc = Pc::find($pc);
					$pc->delete();
				} catch ( Exception $e ) {  
					return json_encode('error');
				}
			}

			return json_encode('success');
		}

		try{
			$pc = Pc::find($id);
			$pc->delete();
		} catch ( Exception $e ) {}

		Session::flash('success-message','Workstation disassembled');
		return Redirect::to('workstation');
	}

	public function deploy()
	{

		if(Request::ajax())
		{
			$room = $this->sanitizeString(Input::get('room'));
			$pc = $this->sanitizeString(Input::get('items'));

			foreach(Pc::separateArray($pc) as $pc)
			{
				try{

					$pc = Pc::find($pc);
					$this->setLocation($pc->systemunit,$room);
					$this->setLocation($pc->monitor,$room);
					$this->setLocation($pc->avr,$room);
					$this->setLocation($pc->keyboard,$room);
					
				} catch(Exception $e) {
					return json_encode('error');
				}

			}

			return json_encode('success');
		}

		$room = $this->sanitizeString(Input::get('room'));
		$pc = $this->sanitizeString(Input::get('items'));

		foreach(Pc::separateArray($pc) as $pc)
		{
			try{

				$pc = Pc::find($pc);
				$this->setLocation($pc->systemunit,$room);
				$this->setLocation($pc->monitor,$room);
				$this->setLocation($pc->avr,$room);
				$this->setLocation($pc->keyboard,$room);

			} catch(Exception $e) {  }

		}

		Session::flash('success-message','Workstation deployed');
		return Redirect::to('workstation/form/deployment');
	}

	public function setLocation($part,$room)
	{
		try{
			$item = Itemprofile::find($part->id);
			$item->location  = $room;
			$room = Room::where('name','=',$room)->first();
			$item->room()->sync([$room->id]);
			$item->save();


		} catch(Exception $e){

			try{
				$room = Room::where('name','=',$room)->first();
				Roominventory::create([
					'room_id' => $room->id,
					'item_id' => $item->id
				]);
			} catch( Exception $e ) {}
		}

	}

	public function transferView()
	{
		return View::make('workstation.transfer');
	}

	public function transfer()
	{
		if(Request::ajax())
		{
			$room = $this->sanitizeString(Input::get('room'));
			$pc = $this->sanitizeString(Input::get('items'));

			foreach(Pc::separateArray($pc) as $pc)
			{
				try{
					$pc = Pc::find($pc);
					$item = Itemprofile::find($pc->systemunit->id);
					// return json_encode($item->room);
					$this->updateLocation($pc->systemunit,$room);
					$this->updateLocation($pc->monitor,$room);
					$this->updateLocation($pc->avr,$room);
					$this->updateLocation($pc->keyboard,$room);
				} catch( Exception $e ){
					return json_encode('error');
				}

			}

			return json_encode('success');
		}

		$room = $this->sanitizeString(Input::get('room'));
		$pc = $this->sanitizeString(Input::get('items'));

		foreach(Pc::separateArray($pc) as $pc)
		{
			try{
				$pc = Pc::find($pc);
				$item = Itemprofile::find($pc->systemunit->id);
				// return json_encode($item->room);
				$this->updateLocation($pc->systemunit,$room);
				$this->updateLocation($pc->monitor,$room);
				$this->updateLocation($pc->avr,$room);
				$this->updateLocation($pc->keyboard,$room);
			} catch( Exception $e ){}

		}

		Session::flash('success-message','Workstation transferred');
		return Redirect::to('workstation/view/transfer');
	}

	public function updateLocation($part,$room)
	{
		try{
			$item = Itemprofile::find($part->id);
			$item->location  = $room;
			$room = Room::where('name',$room)->first();
			$item->room()->sync([$room->id]);
			$item->save();
		} catch ( Exception $e ) {}

	}

}
