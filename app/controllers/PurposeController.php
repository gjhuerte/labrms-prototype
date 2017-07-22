<?php

class PurposeController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if(Request::ajax()){
				return json_encode( [
					'data' => Purpose::select('id','title','description')->get()
				] );
		}

		return View::make('purpose.index');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('purpose.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$title = $this->sanitizeString(Input::get('title'));
		$description = $this->sanitizeString(Input::get('description'));

		$validator = Validator::make([
			'title' => $title,
			'description' => $description
		],Purpose::$rules);

		if($validator->fails()){
			return Redirect::to('purpose')
				->withInput()
				->withErrors($validator);
		}

		$purpose = new Purpose;
		$purpose->title = $title;
		$purpose->description = $description;
		$purpose->save();

		Session::flash('success-message','Record has been added to database');
		return Redirect::to('purpose');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return View::make('purpose.show');
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		try{
			return View::make('purpose.edit')
				->with('purpose',Purpose::find($id));
		} catch( Exception $e ){
			Session::flash('error-message','System has encountered an error');
			return Redirect::to('purpose');
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
		$title = $this->sanitizeString(Input::get('title'));
		$description = $this->sanitizeString(Input::get('description'));

		$validator = Validator::make([
			'title' => $title,
			'description' => $description
		],Purpose::$rules);

		if($validator->fails())
		{
			return Redirect::to("purpose/$id/edit")
				->withInput
				->withErrors($validator);
		}

		try{
			$purpose = Purpose::find($id);
			$purpose->title = $title;
			$purpose->description = $description;
			$purpose->save();
		} catch ( Exception $e ) {
			Session::flash('error-message','System has encountered an error');
			return Redirect::to('purpose');
		}

		Session::flash('success-message','Purpose Updated');
		return Redirect::to('purpose');
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
					$purpose = Purpose::find($id);
					$purpose->delete();
					return json_encode('success');
				} catch( Exception $e ){}
		}

		return Redirect::to('purpose');
	}

	public function getAllPurpose()
	{
		$purpose = Purpose::select('title')->get();
		return json_encode($purpose);
	}


}
