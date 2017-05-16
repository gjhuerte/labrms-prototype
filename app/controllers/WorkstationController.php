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
			->with('workstations',$workstations)
			->with('active_tab','overview');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('workstation.create')
		->with('active_tab','create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$avr = $this->sanitizeString(Input::get('avr'));
		$monitor = $this->sanitizeString(Input::get('monitor'));
		$systemunit = $this->sanitizeString(Input::get('systemunit'));
		$os = $this->sanitizeString(Input::get('os'));
		$keyboard = $this->sanitizeString(Input::get('keyboard'));
		$mouse = $this->sanitizeString(Input::get('mouse'));

		(!empty($keyboard)) ? $keyboard = 1 : $keyboard = 0;
		(!empty($mouse)) ? $mouse = 1 : $mouse = 0;

		$validator = Validator::make([
			'AVR' => $avr,
			'Operating System Key' => $os,
			'Monitor' => $monitor,
			'System Unit' => $systemunit
		],Pc::$rules);

		if($validator->fails())
		{
			return Redirect::back()
				->withInput()
				->withErrors($validator);
		}

		$monitor = $this->getIDFromPropertyNumber($monitor);
		$systemunit = $this->getIDFromPropertyNumber($systemunit);
		$avr = $this->getIDFromPropertyNumber($avr);

		if($this->checkIfTypeIsValid('avr',$avr) == false)
		{
			Session::flash('error-message','Property Number with AVR type does not exists');
			return Redirect::back()
				->withInput();
		}

		if($this->checkIfTypeIsValid('Monitor',$monitor) == false)
		{
			Session::flash('error-message','Property Number with Monitor type does not exists');
			return Redirect::back()
				->withInput();
		}

		if($this->checkIfTypeIsValid('System Unit',$systemunit) == false)
		{
			Session::flash('error-message','Property Number with System Unit type does not exists');
			return Redirect::back()
				->withInput();
		}

		$pc = new Pc;
		$pc->avr_id = $avr;
		$pc->monitor_id = $monitor;
		$pc->systemunit_id = $systemunit;
		$pc->oskey = $os;
		$pc->mouse = $mouse;
		$pc->keyboard = $keyboard;
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

		(!empty($keyboard)) ? $keyboard = 1 : $keyboard = 0;
		(!empty($mouse)) ? $mouse = 1 : $mouse = 0;

		$validator = Validator::make([
			'AVR' => $avr,
			'Operating System Key' => $os,
			'Monitor' => $monitor,
			'System Unit' => $systemunit
		],Pc::$updateRules);

		if($validator->fails())
		{
			return Redirect::back()
				->withInput()
				->withErrors($validator);
		}

		$monitor = $this->getIDFromPropertyNumber($monitor);
		$systemunit = $this->getIDFromPropertyNumber($systemunit);
		$avr = $this->getIDFromPropertyNumber($avr);

		if($this->checkIfTypeIsValid('avr',$avr) == false)
		{
			Session::flash('error-message','Property Number with AVR type does not exists');
			return Redirect::back()
				->withInput();
		}

		if($this->checkIfTypeIsValid('Monitor',$monitor) == false)
		{
			Session::flash('error-message','Property Number with Monitor type does not exists');
			return Redirect::back()
				->withInput();
		}

		if($this->checkIfTypeIsValid('System Unit',$systemunit) == false)
		{
			Session::flash('error-message','Property Number with System Unit type does not exists');
			return Redirect::back()
				->withInput();
		}

		$pc = Pc::find($id);
		$pc->avr_id = $avr;
		$pc->monitor_id = $monitor;
		$pc->systemunit_id = $systemunit;
		$pc->oskey = $os;
		$pc->mouse = $mouse;
		$pc->keyboard = $keyboard;
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
		$pc = Pc::find($id);
		$pc = Pc::find($id);
		$pc->delete();

		Session::flash('success-message','Workstation disassembled');
		return Redirect::to('workstation');
	}

	public function updateView()
	{
			$workstations = Pc::all();
			return View::make('workstation.update-view')
				->with('workstations',$workstations)
				->with('active_tab','update');
	}

	public function deleteView()
	{
			$workstations = Pc::all();
			return View::make('workstation.delete-view')
				->with('workstations',$workstations)
				->with('active_tab','remove');
	}

	public function restoreView()
	{
			$workstations = Pc::all();
			return View::make('workstation.restore-view')
				->with('workstations',$workstations)
				->with('active_tab','restore');
	}

}
