<?php

class WorkstationSoftwareController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('workstation.software.index')
			->with('workstation',Pc::all())
			->with('active_tab','software');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($id)
	{
		$workstation = Pc::find($id);
		if(count($workstation) > 0)
		{
			return View::make('workstation.software.create')
				->with('workstation',$workstation);
		}
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($id)
	{
		$id = $this->sanitizeString($id);
		$software = $this->sanitizeString(Input::get('software'));
		$softwarelicense = $this->sanitizeString(Input::get('softwarelicense'));

		$validator = Validator::make([
			'PC ID' => $id,
			'Software ID' => $software,
			'Software License ID' => $softwarelicense
		],Pcsoftware::$rules);

		if($validator->fails())
		{
			return Redirect::back()
				->withInput()
				->withErrors($validator);
		}

		Softwarelicense::install($softwarelicense);

		$pcsoftware = new Pcsoftware;
		$pcsoftware->pc_id = $id;
		$pcsoftware->software_id = $software;
		$pcsoftware->softwarelicense_id = $softwarelicense;
		$pcsoftware->save();

		Session::flash('success-message','Software added to workstation');
		return Redirect::to('workstation/view/software');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return View::make('workstation.software.show');
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		Pcsoftware::find($id);
		return View::make('workstation.software.edit');
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		Session::flash('success-message','Workstation software successfully updated');
		return Redirect::to('workstation/view/software');
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
			$id = $this->sanitizeString($id);
			$software = $this->sanitizeString(Input::get('software'));
			$softwarelicense = $this->sanitizeString(Input::get('softwarelicense'));

			$validator = Validator::make([
				'PC ID' => $id,
				'Software ID' => $software,
				'Software License ID' => $softwarelicense
			],Pcsoftware::$rules);

			if($validator->fails())
			{
				return json_encode('');
			}

			$pcsoftware = DB::table('pc_software')
												->where('pc_id',$id)
												->where('software_id',$software)
												->where('softwarelicense_id',$softwarelicense)
												->delete();

			Softwarelicense::uninstall($softwarelicense);
			return json_encode('success');
		}

			Session::flash('success-message','Software successfully removed from workstation');
			return Redirect::to('workstation/view/software');
	}

	public function destroyView($id)
	{
			$pcsoftware = Pcsoftware::leftJoin('software','pc_software.software_id','=','software.id')
										->leftJoin('softwarelicense','pc_software.softwarelicense_id','=','softwarelicense.id')
										->where('pc_software.pc_id',$this->sanitizeString($id))
										->select('softwarename as name','key','software.id as softwareid','pc_software.pc_id as pcid','softwarelicense_id as licensekeyid')
										->get();
			return View::make('workstation.software.delete-view')
				->with('software',$pcsoftware)
				->with('active_tab','software');
	}


}
