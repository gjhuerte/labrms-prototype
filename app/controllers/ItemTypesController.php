<?php

class ItemTypesController extends \BaseController {

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
					'data' => Itemtype::select('id','name','description','field')->get()
				]);
		}

		$itemtype = Itemtype::select('id','name','description','field')->get();
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
		$name = $this->sanitizeString(Input::get('name'));
		$description = $this->sanitizeString(Input::get('description'));
		$total = $this->sanitizeString(Input::get('totalFields'));
		$field = "";
		//combines all data in a field
		// $total is the total fields in the form
		$validator = Validator::make([
			'total' => $total
		],[
			'total' => 'integer|required'
		]);

		$validator->sometimes('reason', 'required|integer', function($input)
		{
		    return $input->totalFields > 0;
		});

		if($validator->fails())
		{
				Session::flash('error-message','Page has been modified! The original page will be reloaded');
				return Redirect::to('item/type/create');
		}

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

		$validator = Validator::make([
			'field' => $field,
			'name' => $name,
			'description' => $description
		],Itemtype::$rules);
		if($validator->fails())
		{
			return Redirect::to('item/type/create')
				->withInput()
				->withErrors($validator);
		}

		$itemtype = new Itemtype;
		$itemtype->name = $name;
		$itemtype->description = $description;
		$itemtype->field = $field;
		$itemtype->save();

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
		$name = $this->sanitizeString(Input::get('name'));
		$description = $this->sanitizeString(Input::get('description'));
		$total = $this->sanitizeString(Input::get('totalFields'));
		$field = "";
		//combines all data in a field
		// $total is the total fields in the form
		$validator = Validator::make([
			'total' => $total
		],[
			'total' => 'integer|required'
		]);

		$validator->sometimes('reason', 'required|integer', function($input)
		{
		    return $input->totalFields > 0;
		});

		if($validator->fails())
		{
				Session::flash('error-message','Page has been modified!');
				return Redirect::to('item/type');
		}

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

		$validator = Validator::make([
			'field' => $field,
			'name' => $name,
			'description' => $description
		],Itemtype::$updateRules);

		if($validator->fails())
		{
			return Redirect::to("item/type/$id/edit")
				->withInput()
				->withErrors($validator);
		}

		$itemtype = Itemtype::find($id);
		$itemtype->name = $name;
		$itemtype->description = $description;
		$itemtype->field = $field;
		$itemtype->save();

		Session::flash('success-message','Item type updated');
		return Redirect::to('item/type');
	}

	public function destroy($id)
	{

		if(Request::ajax()){
			try{

				$itemtype = Itemtype::find($id);
				$itemtype->delete();
				return json_encode('success');
			}catch( Exception $e ){}
		}

		try{

			$itemtype = Itemtype::find($id);
			$itemtype->delete();
		}catch( Exception $e ){
			Session::flash('error-message','Item type does not exists');
		}

		Session::flash('success-message','Item type deleted');
		return Redirect::to('item/type/');

	}

	public function restoreView()
	{
		$itemtype = Itemtype::onlyTrashed()->get();
		return View::make('item.type.restore-view')
			->with('itemtype',$itemtype);
	}

	public function restore($id)
	{
		$itemtype = Itemtype::onlyTrashed()->where('id',$id)->first();
		$itemtype->restore();

		Session::flash('success-message','Item type restored');
		return Redirect::to('item/type/view/restore');
	}

}
