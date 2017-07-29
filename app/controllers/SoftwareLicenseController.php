<?php

class SoftwareLicenseController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

		$software_id = $this->sanitizeString(Input::get("id"));
		$licensekey = $this->sanitizeString(Input::get("licensekey"));
		$multiple = $this->sanitizeString(Input::get('usage'));

		$validator = Validator::make([
			'Product Key' => $licensekey
		],SoftwareLicense::$rules);

		if($validator->fails())
		{
			Session::flash('error-message','Problem encountered while processing your request');
			return Redirect::back();
		}

		$softwarelicense = new SoftwareLicense;
		$softwarelicense->software_id = $software_id;
		$softwarelicense->key = $licensekey;
		$softwarelicense->multipleuse = $multiple;
		$softwarelicense->inuse = false;
		$softwarelicense->save();

		Session::flash('success-message','Software License Added');
		return Redirect::to("software/license/$software_id");
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
			return json_encode([
				'data' => Softwarelicense::where('software_id','=',$id)->get()
			]);
		}

		$software = Software::where('id','=',$id)
								->first();
		return View::make('software.show')
			->with('software',$software);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
