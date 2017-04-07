<?php

class ScheduleController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$schedules = Schedule::all();
		return View::make('schedule.index')
			->with('schedules',$schedules);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$rooms = Room::all();
		return View::make('schedule.create')
			->with('rooms',$rooms);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$day = $this->sanitizeString(Input::get('day'));
		$timein = $this->sanitizeString(Input::get('timein'));
		$timeend = $this->sanitizeString(Input::get('timeend'));
		$facultyincharge = $this->sanitizeString(Input::get("facultyincharge"));
		$subject = $this->sanitizeString(Input::get('subject'));
		$semester = $this->sanitizeString(Input::get('semester'));
		$courseyearsection = $this->sanitizeString(Input::get('courseyearsection'));
		$room = $this->sanitizeString(Input::get('roomname'));

		$validator = Validator::make([
				'room name' => $room,
				'day' => $day,
				'start time' => $timein,
				'end time' => $timeend,
				'faculty-in-charge' => $facultyincharge,
				'subject' => $subject,
				'semester' => $semester,
				'course year & section' => $courseyearsection
			],Schedule::$rules);

		if($validator->fails())
		{
			return Redirect::to('schedule/create')
				->withInput()
				->withErrors($validator);
		}

		$schedule = new Schedule;
		$schedule->room_id = $room;
		$schedule->day = $day;
		$schedule->timein = $timein;
		$schedule->timeout = $timeend;
		$schedule->facultyincharge = $facultyincharge;
		$schedule->courseyearsection = $courseyearsection;
		$schedule->subject = $subject;
		$schedule->semester = $semester;
		$schedule->save();

		Session::flash('success-message','Schedule created');
		return Redirect::to('schedule');

	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$schedule = Schedule::find($id);
		return View::make('schedule.show')
			->with('schedule',$schedule);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$rooms = Room::all();
		$schedule = Schedule::find($id);
		return View::make('schedule.update')
			->with('schedule',$schedule)
			->with('rooms',$rooms);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$day = $this->sanitizeString(Input::get('day'));
		$timein = $this->sanitizeString(Input::get('timein'));
		$timeend = $this->sanitizeString(Input::get('timeend'));
		$facultyincharge = $this->sanitizeString(Input::get("facultyincharge"));
		$subject = $this->sanitizeString(Input::get('subject'));
		$semester = $this->sanitizeString(Input::get('semester'));
		$courseyearsection = $this->sanitizeString(Input::get('courseyearsection'));
		$room = $this->sanitizeString(Input::get('roomname'));

		$validator = Validator::make([
				'room name' => $room,
				'day' => $day,
				'start time' => $timein,
				'end time' => $timeend,
				'faculty-in-charge' => $facultyincharge,
				'subject' => $subject,
				'semester' => $semester,
				'course year & section' => $courseyearsection
			],Schedule::$rules);

		if($validator->fails())
		{
			return Redirect::to("schedule/$id/edit")
				->withInput()
				->withErrors($validator);
		}

		$schedule = Schedule::find($id);
		$schedule->room_id = $room;
		$schedule->day = $day;
		$schedule->timein = $timein;
		$schedule->timeout = $timeend;
		$schedule->facultyincharge = $facultyincharge;
		$schedule->courseyearsection = $courseyearsection;
		$schedule->subject = $subject;
		$schedule->semester = $semester;
		$schedule->save();

		Session::flash('success-message','Schedule updated');
		return Redirect::to('schedule');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$schedule = Schedule::find($id);
		$schedule->delete();

		Session::flash('success-message','Schedule deleted');
		return Redirect::to('schedule');

	}


}
