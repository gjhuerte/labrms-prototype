<?php

class SoftwareController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('software.index')
			->with('softwares',Softwarelist::all());
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$licensetypes = [
			'Proprietary license'=>'Proprietary license',
			'GNU General Public License'=>'GNU General Public License',
			'Concurrent use license'=>'Concurrent use license',
			'Site licenses'=>'Site licenses',
			'Perpetual licenses'=>'Perpetual licenses',
			'License with Maintenance'=>'License with Maintenance'
		];
		$softwaretype = Softwaretype::lists('type','type');
		return View::make('software.create')
			->with('licensetype',compact('licensetypes'))
			->with('softwaretype',compact('softwaretype'));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$name = $this->sanitizeString(Input::get('name'));
		$description = $this->sanitizeString(Input::get('description'));
		$licensetype = $this->sanitizeString(Input::get('licensetype'));
		$softwaretype = $this->sanitizeString(Input::get('softwaretype'));
		$requirement = $this->sanitizeString(Input::get('requirement'));

		$validator = Validator::make([
				'name' => $name,
				'description' => $description,
				'license type' => $licensetype,
				'software type' => $softwaretype,
				'requirement' => $requirement
			],Softwarelist::$rules);

		if($validator->fails())
		{
			return Redirect::back()
				->withInput()
				->withErrors($validator);
		}

		$softwarelist = new Softwarelist;
		$softwarelist->name = $name;
		$softwarelist->description = $description;
		$softwarelist->licensetype = $licensetype;
		$softwarelist->softwaretype = $softwaretype;
		$softwarelist->requirement = $requirement;
		$softwarelist->save();

		Session::flash('success-message','Software listed');
		return Redirect::to('software');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{

		return View::make('software.show')
			->with('software',Softwarelist::find($id));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		if(Input::get('assign') == 'Assign')
		{
			$room = Room::lists('name','id');
			return View::make('software.assign')
				->with('room',compact('room'))
				->with('software',Softwarelist::find($id));
		}

		if(Input::get('update') == 'Update')
		{
			$licensetypes = [
				'Proprietary license'=>'Proprietary license',
				'GNU General Public License'=>'GNU General Public License',
				'End User License Agreement (EULA)'=>'End User License Agreement (EULA)',
				'Workstation licenses'=>'Workstation licenses',
				'Concurrent use license'=>'Concurrent use license',
				'Site licenses'=>'Site licenses',
				'Perpetual licenses'=>'Perpetual licenses',
				'Non-perpetual licenses'=>'Non-perpetual licenses',
				'License with Maintenance'=>'License with Maintenance'
			];
			$softwaretype = Softwaretype::lists('type','type');
			return View::make('software.edit')
				->with('software',Softwarelist::find($id))
				->with('licensetype',compact('licensetypes'))
				->with('softwaretype',compact('softwaretype'));

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
		if(Input::get('assign') == 'Assign')
		{
			$software = $this->sanitizeString(Input::get('software'));
			$workstation = $this->sanitizeString(Input::get('workstation'));
			Pcsoftware::create([
					'software_id' => $software,
					'pc_id' => $workstation
				]);

			$systemunit = Pc::find($workstation);
			$property = $systemunit->systemunit->id;
			$title = "Workstation software update";
			$description = "Software added to workstation";
			$clientname = Auth::user()->username;
			$property_number = $property;
			$ticket = new Ticket;
			$ticket->generateMaintenanceTicket($title,$description,$clientname,$property_number);

			Session::flash('success-message','Software assigned');
			return Redirect::to('software');	
		}
		if(Input::get('update') == 'Update')
		{
			$name = $this->sanitizeString(Input::get('name'));
			$description = $this->sanitizeString(Input::get('description'));
			$licensetype = $this->sanitizeString(Input::get('licensetype'));
			$softwaretype = $this->sanitizeString(Input::get('softwaretype'));
			$requirement = $this->sanitizeString(Input::get('requirement'));

			$validator = Validator::make([
					'name' => $name,
					'description' => $description,
					'license type' => $licensetype,
					'software type' => $softwaretype,
					'requirement' => $requirement
				],Softwarelist::$updateRules);

			if($validator->fails())
			{
				return Redirect::back()
					->withInput()
					->withErrors($validator);
			}

			$softwarelist = Softwarelist::find($id);
			$softwarelist->name = $name;
			$softwarelist->description = $description;
			$softwarelist->licensetype = $licensetype;
			$softwarelist->softwaretype = $softwaretype;
			$softwarelist->requirement = $requirement;
			$softwarelist->save();

			Session::flash('success-message','Software updated');
			return Redirect::to('software');	
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
		$software = Softwarelist::find($id);
		$software->delete();
		Session::flash('success-message','Software deleted');
		return Redirect::to('software');	
	}

	public function getWorkstationByRoom()
	{

		if(Request::ajax())
		{
			$workstation = Pc::whereHas('roominventory', function($query)
			{
			    $query->where('room_id','=',$this->sanitizeString(Input::get('room')));

			})->get();
			return json_encode($workstation);
		}

	}


}
