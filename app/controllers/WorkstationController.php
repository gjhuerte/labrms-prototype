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
		$systemunit = $this->sanitizeString(Input::get('systemunit'));
		$monitor = $this->sanitizeString(Input::get('monitor'));
		$avr = $this->sanitizeString(Input::get('avr'));
		$keyboard = $this->sanitizeString(Input::get('keyboard'));
		$oskey = $this->sanitizeString(Input::get('os'));
		$mouse = $this->sanitizeString(Input::get('mouse'));

		$validator = Validator::make([
			'Operating System Key' => $oskey,
			'avr' => $avr,
			'Keyboard' => $keyboard,
			'Monitor' => $monitor,
			'System Unit' => $systemunit,
			'Mouse' => $mouse
		],Pc::$rules);

		if($validator->fails())
		{
			return Redirect::to('workstation/create')
					->withInput()
					->withErrors($validator);
		}

		Pc::assemble($systemunit,$monitor,$avr,$keyboard,$oskey,$mouse);
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

		if(Request::ajax())
		{
			$workstation = Pc::find($id);

			return json_encode([
				'data' => Software::whereHas('roomsoftware',function($query) use ($workstation) {
								$query->where('room_id','=',$workstation->systemunit->roominventory->room_id);
							})
							->with('pcsoftware.softwarelicense')
							->get()
			]);
		}

		try{

			$workstation = Pc::with('systemunit')
						->with('keyboard')
						->with('monitor')
						->find($id);
			$room;
			try
			{
				$room = $workstation->systemunit->roominventory->room_id;
			}
			catch ( Exception $e ) 
			{
				try 
				{
					$room = $workstation->monitor->roominventory->room_id;
				} 
				catch ( Exception $e ) 
				{
					try
					{
						$room = $workstation->keyboard->roominventory->room_id;
					}
					catch (Exception $e ) 
					{

						$room = $workstation->avr->roominventory->room_id;
					}
				}
			}


			try
			{
				$software = Software::whereHas('roomsoftware',function($query) use ($room) {
							$query->where('room_id','=',$room);
						})->get();
			} 
			catch (Exception $e) 
			{ 
				$software = '';
			}

			return View::make('workstation.show')
				->with('workstation',$workstation)
				->with('software',$software);

		} 
		catch (Exception $e) 
		{
			return Redirect::to('workstation');
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

	/**
	*
	*	function for deploying pc to another location
	*	@param $room accepts room name
	*	@param $pc accepts pc id list
	*
	*/
	public function deploy()
	{

		/**
		*
		*	check if the request is ajax
		*
		*/
		if(Request::ajax())
		{
			$room = $this->sanitizeString(Input::get('room'));
			$pc = $this->sanitizeString(Input::get('items'));

			foreach(Pc::separateArray($pc) as $pc)
			{
				try
				{
					Pc::setPcLocation($pc,$room);
				} 
				catch(Exception $e) 
				{
					return $e;
					return json_encode('error');
				}

			}

			return json_encode('success');
		}

		/**
		*
		*	normal request
		*
		*/
		$room = $this->sanitizeString(Input::get('room'));
		$pc = $this->sanitizeString(Input::get('items'));

		foreach(Pc::separateArray($pc) as $pc)
		{
			try
			{
				Pc::setPcLocation($pc,$room);
			} 
			catch(Exception $e) 
			{
				return json_encode('error');
			}

		}

		Session::flash('success-message','Workstation deployed');
		return Redirect::to('workstation/form/deployment');
	}

	/**
	*
	*	function for transfering pc to another location
	*	@param $room accepts room name
	*	@param $pc accepts pc id list
	*
	*/
	public function transfer()
	{

		/**
		*
		*	check if the request is ajax
		*
		*/
		if(Request::ajax())
		{
			$room = $this->sanitizeString(Input::get('room'));
			$pc = $this->sanitizeString(Input::get('items'));

			foreach(Pc::separateArray($pc) as $pc)
			{
				try
				{
					Pc::setPcLocation($pc,$room);
				} 
				catch(Exception $e) 
				{
					return json_encode('error');
				}

			}
			return json_encode('success');
		}

		/**
		*
		*	normal request
		*
		*/
		$room = $this->sanitizeString(Input::get('room'));
		$pc = $this->sanitizeString(Input::get('items'));

		foreach(Pc::separateArray($pc) as $pc)
		{
			try
			{
				Pc::setPcLocation($pc,$room);
			} 
			catch(Exception $e) 
			{
				return json_encode('error');
			}

		}

		Session::flash('success-message','Workstation transferred');
		return Redirect::to('workstation/view/transfer');
	}

}
