<?php

class ItemTypesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$itemtype = Itemtype::all();
		return View::make('item.type.index')
			->with('itemtype',$itemtype);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */

	public function create()
	{
		return View::make('item.type.create');
	}

	public function store()
	{
		$data = [
			'type' => Input::get('name'),
			'description' => Input::get('description')
		];

		$validator = Validator::make($data,Itemtype::$rules);
		if($validator->fails())
		{
			return Redirect::back()
				->withInput()
				->withErrors($validator);
		}

		$type = new Itemtype;
		$type->type = Input::get('name');
		$type->description = Input::get('description');
		$type->save();

		Session::flash('success-message','Item type created');
		return Redirect::to('item/type');
	}

	public function edit($id)
	{
		$itemtype = Itemtype::find($id);
		return View::make('item.type.edit')
			->with('itemtype',$itemtype);
	}

	public function update($id)
	{
		$data = [
			'type' => Input::get('type'),
			'description' => Input::get('description')
		];

		$validator = Validator::make($data,Itemtype::$rules);
		if($validator->fails())
		{
			return Redirect::back()
				->withInput()
				->withErrors($validator);
		}

		$itemtype = Itemtype::find($id);
		$itemtype->type = Input::get('name');
		$itemtype->description = Input::get('description');
		$itemtype->save();

		Session::flash('success-message','Item type updated');
		return Redirect::to('item/type');
	}

	public function destroy($id)
	{
		$itemtype = Itemtype::find($id);
		$itemtype->delete();
		Session::flash('success-message','Item type deleted');
		return Redirect::to('item/type');

	}

	public function getAllItemTypes()
	{
		if(Request::ajax())
		{
			$itemtype = Itemtype::all();
			return json_encode($itemtype);
		}
	}


}
