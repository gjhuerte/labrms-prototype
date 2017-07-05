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
			$workstation = Pc::all();
			$data = [];
			foreach($workstation as $workstation)
			{
				$data = array_add($data,[
					'oskey' => $workstation->oskey,
					'systemunit' => $workstation->systemunit->propertynumber,
					'monitor' => $workstation->monitor->propertynumber,
					'avr' => $workstation->avr->propertynumber,
					'keyboard' => $workstation->keyboard->propertynumber,
					'mouse' => $workstation->mouse
				]);
			}
			return json_encode(['data'=> $data]);
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

		return Input::all();



		/*
		*
		*  Initiate all values
		*
		*/

		//workstations

		$workstations = "";

		for( $ctr = 0; Input::has('systemunit_propertynumber'.$ctr) ; $ctr++ ){

			$workstations[$ctr] = array( 'systemunit' => [
				'propertynumber' => $this->sanitizeString(Input::get('systemunit_propertynumber'.$ctr)),
				'serialid' => $this->sanitizeString(Input::get('systemunit_serialid'.$ctr))
			], 'monitor' => [
				'propertynumber' => $this->sanitizeString(Input::get('monitor_propertynumber'.$ctr)),
				'serialid' => $this->sanitizeString(Input::get('monitor_serialid'.$ctr))
			] );

		}

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

		return count($workstations);


		(!empty($mouse)) ? $mouse = 1 : $mouse = 0;

		$validator = Validator::make([
			'AVR' => $avr,
			'Operating System Key' => $os,
			'Monitor' => $monitor,
			'Keyboard' => $keyboard,
			'System Unit' => $systemunit
		],Pc::$rules);

		if($validator->fails())
		{
			return Redirect::back()
				->withInput()
				->withErrors($validator);
		}

		$monitor = $this->get_id_from_property_number($monitor);
		$systemunit = $this->get_id_from_property_number($systemunit);

		if($this->check_if_correct_type($avr,'AVR') == false)
		{
			Session::flash('error-message','Property Number with AVR type does not exists');
			return Redirect::back()
				->withInput();
		}

		if($this->check_if_correct_type($monitor,'Display') == false)
		{
			Session::flash('error-message','Property Number with Monitor type does not exists');
			return Redirect::back()
				->withInput();
		}

		if($this->check_if_correct_type($systemunit,'System Unit') == false)
		{
			Session::flash('error-message','Property Number with System Unit type does not exists');
			return Redirect::back()
				->withInput();
		}

		if($this->check_if_correct_type($keyboard,'Keyboard') == false)
		{
			Session::flash('error-message','Property Number with Keyboard type does not exists');
			return Redirect::back()
				->withInput();
		}

		$pc = new Pc;
		$pc->avr_id = $avr;
		$pc->monitor_id = $monitor;
		$pc->systemunit_id = $systemunit;
		$pc->keyboard_id = $keyboard;
		$pc->oskey = $os;
		$pc->mouse = $mouse;
		$pc->save();

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
		return View::make('workstation.edit')
			->with('pc',Pc::find($id));
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
		  return Redirect::back()
		    ->withInput()
		    ->withErrors($validator);
		}

		(!empty($mouse)) ? $mouse = 1 : $mouse = 0;

		$pc = Pc::find($id);

		if(count($this->get_id_from_property_number($monitor)) > 0)
		{
			$monitor = $this->get_id_from_property_number($monitor);

			if($this->check_if_correct_type($monitor,'Display') == true)
			{
				$pc->monitor_id = $monitor;
			}else{
				unset($monitor);
			}

		}else{
			unset($monitor);
		}

		if(count($this->get_id_from_property_number($systemunit)) > 0)
		{
			$systemunit = $this->get_id_from_property_number($systemunit);

			if($this->check_if_correct_type($systemunit,'System Unit') == true)
			{
				$pc->systemunit_id = $systemunit;
			}else{
					unset($systemunit);
			}

		}else{
			unset($systemunit);
		}

		if(count($this->get_id_from_property_number($avr)) > 0)
		{
			$avr = $this->get_id_from_property_number($avr);

			if($this->check_if_correct_type($avr,'AVR') == true)
			{
				$pc->avr_id = $avr;
			}else{
				unset($avr);
			}

		}else{
			unset($avr);
		}

		if(count($this->get_id_from_property_number($keyboard)) > 0)
		{
			$keyboard = $this->get_id_from_property_number($keyboard);

			if($this->check_if_correct_type($keyboard,'Keyboard') == true)
			{
				$pc->keyboard_id = $keyboard;
			}else{
				unset($keyboard);
			}

		}else{
			unset($keyboard);
		}

		if(!isset($keyboard) && !isset($monitor) && !isset($systemunit) && !isset($avr) && $pc->oskey == $os && $pc->mouse == $mouse){
			Session::flash('error-message','No changes detected');
			return Redirect::back();
		}

		$pc->oskey = $os;
		$pc->mouse = $mouse;

		$pc->save();

		Session::flash('success-message','Workstation information updated');
		return Redirect::to('workstation/view/update');
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
		$pc->delete();

		Session::flash('success-message','Workstation disassembled');
		return Redirect::to('workstation/view/delete');
	}

	public function updateView()
	{
			$workstations = Pc::all();
			return View::make('workstation.update-view')
				->with('workstations',$workstations);
	}

	public function deleteView()
	{
			$workstations = Pc::all();
			return View::make('workstation.delete-view')
				->with('workstations',$workstations);
	}

	public function deployment()
	{
		return View::make('workstation.deployment');
	}

	public function deploy()
	{
		$room = $this->sanitizeString(Input::get('room'));
		$pc = $this->sanitizeString(Input::get('pc'));

		foreach(Itemtype::getField($pc) as $pc)
		{
			$pc = Pc::find($pc);

			if(count($pc) > 0)
			{

				$this->setLocation($pc->systemunit,$room);
				$this->setLocation($pc->monitor,$room);
				$this->setLocation($pc->avr,$room);
				$this->setLocation($pc->keyboard,$room);

			}

		}

		Session::flash('success-message','Workstation deployed');
		return Redirect::to('workstation/form/deployment');
	}

	public function setLocation($part,$room)
	{

		if(count($part) > 0)
		{
			$item = Itemprofile::find($part->id);
			$item->location  = $room;
			$item->save();

			$room = Room::where('name',$room)->first();

			//check if room is valid
			//assigns to room inventory

			if(count(Roominventory::where('room_id',$room->id)->first()) > 0 && count(Roominventory::where('item_id',$item->id)->first()) > 0)
			{
				$item->room()->sync([$room->id]);
			}else if(count($room) > 0)
			{
				Roominventory::create([
					'room_id' => $room->id,
					'item_id' => $item->id
				]);
			}


		}

	}

	public function updateLocation($part,$room)
	{

		if(count($part) > 0)
		{
			$item = Itemprofile::find($part->id);
			$item->location  = $room;

			$room = Room::where('name',$room)->first();

			//check if room is valid
			//assigns to room inventory
			if(count($room) > 0)
			{
				$item->room()->sync([$room->id]);
			}

			$item->save();
		}

	}

	public function transferView()
	{
		return View::make('workstation.transfer');
	}

	public function transfer()
	{

		$room = $this->sanitizeString(Input::get('room'));
		$pc = $this->sanitizeString(Input::get('pc'));

		foreach(Itemtype::getField($pc) as $pc)
		{
			$pc = Pc::find($pc);

			if(count($pc) > 0)
			{
				$item = Itemprofile::find($pc->systemunit->id);
				// return json_encode($item->room);
				$this->updateLocation($pc->systemunit,$room);
				$this->updateLocation($pc->monitor,$room);
				$this->updateLocation($pc->avr,$room);
				$this->updateLocation($pc->keyboard,$room);

			}

		}

		Session::flash('success-message','Workstation transferred');
		return Redirect::to('workstation/view/transfer');
	}

}
