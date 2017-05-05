<?php

class FacultyController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$user = User::all();
		return View::make('faculty.index')
			->with('user',$user)
			->with('active_tab','overview');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('faculty.create')
			->with('active_tab','add');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		Session::has('success-message','New Faculty Added');
		return Redirect::to('faculty.index');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return View::make('faculty.show');
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		return View::make('faculty.edit');
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		Session::has('success-message','Faculty Information Updated');
		return Redirect::to('faculty.index');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Session::has('success-message','Faculty Removed from Database');
		return Redirect::to('faculty.index');
	}

	public function updateView()
	{
		$user = User::all();
		return View::make('faculty.update-view')
			->with('user',$user)
			->with('active_tab','update');
	}

	public function deleteView()
	{
		$user = User::all();
		return View::make('faculty.delete-view')
			->with('user',$user)
			->with('active_tab','remove');		
	}


}
