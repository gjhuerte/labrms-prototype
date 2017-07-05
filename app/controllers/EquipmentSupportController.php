<?php

class EquipmentSupportController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('equipment.support.index');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('equipment.support.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$type = $this->sanitizeString(Input::get('maintenancetype'));
		$problem = $this->sanitizeString(Input::get('problem'));

		$validator = Validator::make([
			'type' => $type,
			'problem / category' => $problem
		],Equipmentsupport::$rules);

		if($validator->fails())
		{
			return Redirect::to('equipment/support/create')
				->withInput()
				->withErrors($validator);
		}

		$equipmentsupport = new Equipmentsupport;
		$equipmentsupport->type = $type;
		$equipmentsupport->problem = $problem;
		$equipmentsupport->save();
		Session::flash('success-message','Activity added');
		return Redirect::to('equipment/support');
	}

	public function edit($id)
	{
		try{
			$equipment = Equipmentsupport::find($id);
			return View::make('equipment.support.edit')
					->with('equipmentsupport',$equipment);
		} catch( Exception $e ){

		}
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$type = $this->sanitizeString(Input::get('maintenancetype'));
		$problem = $this->sanitizeString(Input::get('problem'));

		$validator = Validator::make([
			'type' => $type,
			'problem / category' => $problem
		],Equipmentsupport::$rules);

		if($validator->fails())
		{
			return Redirect::to("equipment/support/$id/edit")
				->withInput()
				->withErrors($validator);
		}

		$equipmentsupport = Equipmentsupport::find($id);
		$equipmentsupport->type = $type;
		$equipmentsupport->problem = $problem;
		$equipmentsupport->save();
		Session::flash('success-message','Activity updated');
		return Redirect::to('equipment/support/');
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
			$id = $this->sanitizeString(Input::get('id'));
			$equipmentsupport = Equipmentsupport::find($id);
			$equipmentsupport->delete();
			return json_encode('success');
		}
		$equipmentsupport = equipmentsupport::find($id);
		$equipmentsupport->delete();
		Session::flash('success-message','Activity removed');
		return Redirect::to('equipment/support');
	}


}
