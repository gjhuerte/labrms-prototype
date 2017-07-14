<?php

class HolidayController extends \BaseController {

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
				'data' => Holiday::all()
			]);
		}
		return View::make('holiday.index');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('holiday.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$title = $this->sanitizeString(Input::get('title'));
		$date = $this->sanitizeString(Input::get('date'));

		$validator = Validator::make([
			'title' => $title,
			'date' => $date
		],Holiday::$rules);

		$holiday = new Holiday;
		$holiday->title = $title;
		$holiday->date = Carbon\Carbon::parse($date);
		$holiday->save();

		Session::flash('success-message','Holiday Created');
		return Redirect::to('holiday');
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
		try{
			$holiday = Holiday::find($id);
			return View::make('holiday.edit')
					->with('holiday',$holiday);
		} catch(Exception $e) {
			Session::flash('error-message','Error occured while processing your data');
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
		$date = $this->sanitizeString(Input::get('date'));

		$validator = Validator::make([
			'title' => $title,
			'date' => $date
		],Holiday::$rules);

		try{
			$holiday = Holiday::find($id);
			$holiday->title = $title;
			$holiday->date = Carbon\Carbon::parse($date);
			$holiday->save();
		} catch(Exception $e) {
			Session::flash('error-message','Error occured while processing your data');
		}

		Session::flash('success-message','Holiday Updated');
		return Redirect::to('holiday');
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
				$holiday = Holiday::find($id);
				$holiday->delete();
				return json_encode('success');
			} catch(Exception $e) {
				return json_encode('error');
			}
		}
		try{
			$holiday = Holiday::find($id);
			$holiday->delete();
		} catch(Exception $e) {
			Session::flash('error-message','Error occured while processing your data');
		}
		Session::flash('success-message','Holiday Removed');
		return Redirect::to('holiday');
	}


}
