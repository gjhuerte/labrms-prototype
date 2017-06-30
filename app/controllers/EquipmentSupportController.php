<?php

class EquipmentSupportController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('equipment.support.index')
			->with('active_tab','overview');
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
			return Redirect::back()
				->withInput()
				->withErrors($validator);
		}

		$equipmentsupport = new Equipmentsupport;
		$equipmentsupport->type = $type;
		$equipmentsupport->problem = $problem;
		$equipmentsupport->save();
		Session::flash('success-message','Equipment Support Category added');
		return Redirect::to('equipment/support');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		return View::make('equipment.support.edit')
			->with('equipmentsupport',Equipmentsupport::find($id)->select('id','type','problem')->first());
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
			return Redirect::back()
				->withInput()
				->withErrors($validator);
		}

		$equipmentsupport = Equipmentsupport::find($id);
		$equipmentsupport->type = $type;
		$equipmentsupport->problem = $problem;
		$equipmentsupport->save();
		Session::flash('success-message','Equipment Support Category updated');
		return Redirect::to('equipment/support/view/update');
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
			return 'success';
		}
		$equipmentsupport = equipmentsupport::find($id);
		$equipmentsupport->delete();
		Session::flash('success-message','Equipment Support Category removed');
		return Redirect::to('equipment/support/view/delete');
	}

	public function updateView()
	{
		return View::make('equipment.support.update-view')
			->with('active_tab','update');
	}

	public function deleteView()
	{
		return View::make('equipment.support.delete-view')
			->with('active_tab','remove');
	}


}
