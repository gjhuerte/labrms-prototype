<?php

class SoftwareController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		if(Request::ajax())
		{
			return json_encode(['data'=>Software::all()]);
		}

		return View::make('software.index');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('software.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$name = $this->sanitizeString(Input::get('name'));
		$company = $this->sanitizeString(Input::get('company'));
		$licensetype = $this->sanitizeString(Input::get('licensetype'));
		$softwaretype = $this->sanitizeString(Input::get('softwaretype'));
		$licensekey = $this->sanitizeString(Input::get('licensekey'));
		$multiple = $this->sanitizeString(Input::get('multiple'));
		$minrequirement = $this->sanitizeString(Input::get('minrequirement'));
		$maxrequirement = $this->sanitizeString(Input::get('maxrequirement'));

		if($multiple == "on")
		{
			$multiple = 1;
		}

		$validator = Validator::make([
				'Software Name' => $name,
				'Software Type' => $softwaretype,
				'License Type' => $licensetype,
				'company' => $company,
				'Minimum System Requirement' => $minrequirement,
				'Maximum System Requirement' => $maxrequirement,
			],Software::$rules);

		$validator = Validator::make([
			'Product Key' => 'licensekey'
		],Softwarelicense::$rules);

		if($validator->fails())
		{
			return Redirect::back()
				->withInput()
				->withErrors($validator);
		}

		$software = new Software;
		$software->softwarename = $name;
		$software->company = $company;
		$software->licensetype = $licensetype;
		$software->softwaretype = $softwaretype;
		$software->minsysreq = $minrequirement;
		$software->maxsysreq = $maxrequirement;
		$software->save();

		$softwarelicense = new Softwarelicense;
		$softwarelicense->software_id = $software->id;
		$softwarelicense->key = $licensekey;
		$softwarelicense->multipleuse = $multiple;
		$softwarelicense->inuse = false;
		$softwarelicense->save();


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
			->with('software',Software::find($id));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		return View::make('software.edit')
			->with('software',Software::find($id));
	}

	public function assign($id)
	{

		$room = Room::lists('name','id');
		return View::make('software.assign')
			->with('room',compact('room'))
			->with('software',Software::find($id));
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
		$name = $this->sanitizeString(Input::get('name'));
		$company = $this->sanitizeString(Input::get('company'));
		$licensetype = $this->sanitizeString(Input::get('licensetype'));
		$softwaretype = $this->sanitizeString(Input::get('softwaretype'));
		$licensekey = $this->sanitizeString(Input::get('licensekey'));
		$multiple = $this->sanitizeString(Input::get('multiple'));
		$minrequirement = $this->sanitizeString(Input::get('minrequirement'));
		$maxrequirement = $this->sanitizeString(Input::get('maxrequirement'));

		if($multiple == "on")
		{
			$multiple = 1;
		}

		$validator = Validator::make([
				'Software Name' => $name,
				'Software Type' => $softwaretype,
				'License Type' => $licensetype,
				'company' => $company,
				'Minimum System Requirement' => $minrequirement,
				'Maximum System Requirement' => $maxrequirement,
			],Software::$rules);

		$validator = Validator::make([
			'Product Key' => 'licensekey'
		],Softwarelicense::$updateRules);

		if($validator->fails())
		{
			return Redirect::to("software/$id/edit")
				->withInput()
				->withErrors($validator);
		}

		$software = Software::find($id);
		$software->softwarename = $name;
		$software->company = $company;
		$software->licensetype = $licensetype;
		$software->softwaretype = $softwaretype;
		$software->minsysreq = $minrequirement;
		$software->maxsysreq = $maxrequirement;
		$software->save();

		$softwarelicense = Softwarelicense::where('software_id',$software->id)->first();
		$softwarelicense->software_id = $software->id;
		$softwarelicense->key = $licensekey;
		$softwarelicense->multipleuse = $multiple;
		$softwarelicense->inuse = false;
		$softwarelicense->save();

		Session::flash('success-message','Software updated');
		return Redirect::to('software');
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
			try{
				$software = Software::find($id);
				$software->delete();
				return json_encode('success');
			}catch (Exception $e){}
		}
		Session::flash('success-message','Software deleted');
		return Redirect::to('software');
	}

	public function restore($id){
		$software = Software::onlyTrashed()->where('id',$id)->first();
		$software->restore();
		Session::flash('success-message','Software restored');
		return Redirect::to('software/view/restore');
	}
}
