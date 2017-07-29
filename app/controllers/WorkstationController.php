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
		$systemunit_id = $this->sanitizeString(Input::get('systemunit'));
		$monitor_id = $this->sanitizeString(Input::get('monitor'));
		$avr_id = $this->sanitizeString(Input::get('avr'));
		$keyboard_id = $this->sanitizeString(Input::get('keyboard'));
		$oskey = $this->sanitizeString(Input::get('os'));
		$mouse = $this->sanitizeString(Input::get('mouse'));

		$validator = Validator::make([
			'Operating System Key' => $oskey,
			'avr' => $avr_id,
			'Keyboard' => $keyboard_id,
			'Monitor' => $monitor_id,
			'System Unit' => $systemunit_id
		],Pc::$rules);

		if($validator->fails())
		{
			return Redirect::to('workstation/create')
					->withInput()
					->withErrors($validator);
		}

		$systemunit_id = Itemprofile::where('propertynumber','=',$systemunit_id)->first();
		$monitor_id = Itemprofile::where('propertynumber','=',$monitor_id)->first();
		$avr_id = Itemprofile::where('propertynumber','=',$avr_id)->first();
		$keyboard_id = Itemprofile::where('propertynumber','=',$keyboard_id)->first();

		try
		{
			if(count($systemunit_id) > 0)
				$systemunit_id = $systemunit_id->id;
			else 
				$systemunit_id = null;
			if(count($monitor_id) > 0)
				$monitor_id = $monitor_id->id;
			else 
				$monitor_id = null;
			if(count($avr_id) > 0)
				$avr_id = $avr_id->id;
			else 
				$avr_id = null;
			if(count($keyboard_id) > 0)
				$keyboard_id = $keyboard_id->id;
			else 
				$keyboard_id = null;

		} catch (Exception $e) {
			return Redirect::to('workstation/create')
					->withInput()
					->withErrors(['Invalid Property Number']);
		}

		try{
			$supply = Supply::where('brand','=',$mouse)->first();
			if($supply->quantity == 0)
			{
				return Redirect::to('workstation/create')
						->withInput()
						->withErrors(['No more supplies to release']);
			}
			$supply->quantity = $supply->quantity - 1;
			$supply->save();
		} catch (Exception $e) {
			return Redirect::to('workstation/create')
					->withInput()
					->withErrors(['Mouse not found']);
		}

		$pc = new Pc;
		$pc->systemunit_id = $systemunit_id;
		$pc->monitor_id = $monitor_id;
		$pc->avr_id = $avr_id;
		$pc->keyboard_id = $keyboard_id;
		$pc->oskey = $oskey;
		$pc->mouse = $mouse;
		$pc->save();

		Session::flash('success-message','Workstation assembled');
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
