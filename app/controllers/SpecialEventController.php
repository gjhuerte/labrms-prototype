<?php

class SpecialEventController extends \BaseController {

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
				'data' => SpecialEvent::all()
			]);
		}
		return View::make('event.index');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('event.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// return Input::all();
		$title = $this->sanitizeString(Input::get('title'));
		$date = $this->sanitizeString(Input::get('date'));
		$repeating = ( $this->sanitizeString(Input::get('multiple')) == 'on' ) ? true : false;

		$repeatingFormat = $this->sanitizeString(Input::get('repeatingFormat'));

		$validator = Validator::make([
			'title' => $title,
			'date' => $date
		],SpecialEvent::$rules);

		$event = new SpecialEvent;
		$event->title = $title;
		$event->repeating = $repeating;

		if($repeating)
		{
			$event->repeatingFormat = $repeatingFormat;	
		}

		$event->date = Carbon\Carbon::parse($date);
		$event->save();

		Session::flash('success-message','Event Created');
		return Redirect::to('event');
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
			$event = SpecialEvent::find($id);
			return View::make('event.edit')
					->with('event',$event);
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
		$repeating = ( $this->sanitizeString(Input::get('multiple')) == 'on' ) ? true : false;

		$repeatingFormat = $this->sanitizeString(Input::get('repeatingFormat'));


		$validator = Validator::make([
			'title' => $title,
			'date' => $date
		],SpecialEvent::$rules);

		try{
			$event = SpecialEvent::find($id);
			$event->title = $title;
			$event->date = Carbon\Carbon::parse($date);

			$event->repeating = $repeating;

			if($repeating)
			{
				$event->repeatingFormat = $repeatingFormat;	
			}

			$event->save();
		} catch(Exception $e) {
			Session::flash('error-message','Error occured while processing your data');
		}

		Session::flash('success-message','Event Updated');
		return Redirect::to('event');
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
				$event = SpecialEvent::find($id);
				$event->delete();
				return json_encode('success');
			} catch(Exception $e) {
				return json_encode('error');
			}
		}
		try{
			$event = SpecialEvent::find($id);
			$event->delete();
		} catch(Exception $e) {
			Session::flash('error-message','Error occured while processing your data');
		}
		Session::flash('success-message','Event Removed');
		return Redirect::to('event');
	}


}
