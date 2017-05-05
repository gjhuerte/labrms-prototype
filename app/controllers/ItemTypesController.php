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
			->with('itemtype',$itemtype)
			->with('active_tab','overview');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */

	public function create()
	{
		return View::make('item.type.create')
			->with('active_tab','add');
	}

	public function store()
	{
		// $data = [
		// 	'type' => Input::get('name'),
		// 	'description' => Input::get('description')
		// ];

		// $validator = Validator::make($data,Itemtype::$rules);
		// if($validator->fails())
		// {
		// 	return Redirect::back()
		// 		->withInput()
		// 		->withErrors($validator);
		// }

		// $type = new Itemtype;
		// $type->type = Input::get('name');
		// $type->description = Input::get('description');
		// $type->save();

		// Session::flash('success-message','Item type created');
		// return Redirect::to('item/type');
		$total = $this->sanitizeString(Input::get('totalFields'));
		$field = "";

		//combines all data in a field
		// $total is the total fields in the form
		for($ctr = 0;$ctr < $total;$ctr++)
		{
			$form = $this->sanitizeString(Input::get('form'.$ctr));
			// validates if the form exists or has content
			// needs to add more validations to this field
			if($form != "" || !empty($form)){
				// check if the form is the first
				// if the form is the first, adds a ','
				if($ctr > 0) $field = $field.",";
				//adds the form to the existing field variable
				$field = $field.$form;
			}
		}

		return "Fields: ".$field;
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

	public function updateView()
	{
		$itemtype = Itemtype::all();
		return View::make('item.type.update-view')
			->with('itemtype',$itemtype)
			->with('active_tab','update');
	}

	public function removeView()
	{

		$itemtype = Itemtype::all();
		return View::make('item.type.remove-view')
			->with('itemtype',$itemtype)
			->with('active_tab','remove');
	}

	public function getAllItemTypes()
	{
		if(Request::ajax())
		{
			$itemtype = Itemtype::all();
			return json_encode($itemtype);
		}
	}

	public function getItemTypes()
	{
		if(Request::ajax())
		{
			$itemtype = Itemtype::all();
			return $itemtype->paginate(2);
		}
	}

}
