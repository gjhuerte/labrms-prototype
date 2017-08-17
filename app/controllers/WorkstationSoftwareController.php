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
		if(Request::ajax())
		{
			$id = $this->sanitizeString($id);
			$software = $this->sanitizeString(Input::get('software'));
			$softwarelicense = $this->sanitizeString(Input::get('softwarelicense'));

			$validator = Validator::make([
				'PC ID' => $id,
				'Software ID' => $software,
				'Software License Key' => $softwarelicense
			],Pcsoftware::$rules);

			if($validator->fails())
			{
				return json_encode('error');
			}

			PcSoftware::installSoftware($id,$software,$softwarelicense);

			return json_encode('success');
		}

		$id = $this->sanitizeString($id);
		$software = $this->sanitizeString(Input::get('software'));
		$softwarelicense = $this->sanitizeString(Input::get('softwarelicense'));

		$validator = Validator::make([
			'PC ID' => $id,
			'Software ID' => $software,
			'Software License Key' => $softwarelicense
		],PcSoftware::$rules);

		if($validator->fails())
		{
			return Redirect::back()
				->withInput()
				->withErrors($validator);
		}

		PcSoftware::installSoftware($id,$software,$softwarelicense);

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
		if(Request::ajax())
		{
			$id = $this->sanitizeString($id);
			$software = $this->sanitizeString(Input::get('software'));

			$validator = Validator::make([
				'PC ID' => $id,
				'Software ID' => $software
			],Pcsoftware::$withoutLicenseRules);

			if($validator->fails())
			{
				return json_encode('error');
			}

			PcSoftware::updateInstalledSoftware($id,$software);
			return json_encode('success');
		}

		$id = $this->sanitizeString($id);
		$software = $this->sanitizeString(Input::get('software'));
		$softwarelicense = $this->sanitizeString(Input::get('softwarelicense'));

		$validator = Validator::make([
			'PC ID' => $id,
			'Software ID' => $software,
			'Software License Key' => $softwarelicense
		],PcSoftware::$rules);

		if($validator->fails())
		{
			return Redirect::back()
				->withInput()
				->withErrors($validator);
		}

		SoftwareLicense::install($softwarelicense);

		$pcsoftware = new PcSoftware;
		$pcsoftware->pc_id = $id;
		$pcsoftware->software_id = $software;
		$pcsoftware->softwarelicense_id = $softwarelicense;
		$pcsoftware->save();

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

			$validator = Validator::make([
				'PC ID' => $id,
				'Software ID' => $software
			],Pcsoftware::$withoutLicenseRules);

			if($validator->fails())
			{
				return json_encode('error');
			}

			PcSoftware::uninstallSoftware($id,$software);
			return json_encode('success');
		}

		Session::flash('success-message','Software successfully removed from workstation');
		return Redirect::to('workstation/view/software');
	}


}
