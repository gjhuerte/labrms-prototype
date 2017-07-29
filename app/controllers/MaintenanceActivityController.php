<?php

class MaintenanceActivityController extends \BaseController {

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
				'data' => MaintenanceActivity::all()
			]);
		}
		return View::make('maintenance.activity.index');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('maintenance.activity.create');
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
		],MaintenanceActivity::$rules);

		if($validator->fails())
		{
			return Redirect::to('maintenance/activity/create')
				->withInput()
				->withErrors($validator);
		}

		$MaintenanceActivity = new MaintenanceActivity;
		$MaintenanceActivity->type = $type;
		$MaintenanceActivity->problem = $problem;
		$MaintenanceActivity->save();
		Session::flash('success-message','Activity added');
		return Redirect::to('maintenance/activity');
	}

	public function edit($id)
	{
		try{
			$equipment = MaintenanceActivity::find($id);
			return View::make('maintenance.activity.edit')
					->with('MaintenanceActivity',$equipment);
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
		$id = $this->sanitizeString(Input::get('id'));
		$type = $this->sanitizeString(Input::get('maintenancetype'));
		$problem = $this->sanitizeString(Input::get('problem'));

		$validator = Validator::make([
			'type' => $type,
			'problem / category' => $problem
		],MaintenanceActivity::$rules);

		if($validator->fails())
		{
			return Redirect::to("maintenance/activity/$id/edit")
				->withInput()
				->withErrors($validator);
		}

		$maintenanceActivity = MaintenanceActivity::find($id);
		$maintenanceActivity->type = $type;
		$maintenanceActivity->problem = $problem;
		$maintenanceActivity->save();
		Session::flash('success-message','Activity updated');
		return Redirect::to('maintenance/activity/');
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
			$MaintenanceActivity = MaintenanceActivity::find($id);
			$MaintenanceActivity->delete();
			return json_encode('success');
		}
		$MaintenanceActivity = MaintenanceActivity::find($id);
		$MaintenanceActivity->delete();
		Session::flash('success-message','Activity removed');
		return Redirect::to('maintenance/activity');
	}


}
