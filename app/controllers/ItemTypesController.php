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
				$itemtype = Itemtype::select('id','name')->get();
				return json_encode($itemtype);
		}

		$itemtype = Itemtype::select('id','name','description','field')->get();
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
			return Redirect::back()
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
				Session::flash('error-message','Page has been modified! Returning to Update Table');
				return Redirect::to('item/type/view/update');
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
			return Redirect::back()
				->withInput()
				->withErrors($validator);
		}

		$itemtype = Itemtype::find($id);
		$itemtype->name = $name;
		$itemtype->description = $description;
		$itemtype->field = $field;
		$itemtype->save();

		Session::flash('success-message','Item type updated');
		return Redirect::to('item/type/view/update');
	}

	public function destroy($id)
	{
		$itemtype = Itemtype::find($id);
		$itemtype->delete();
		Session::flash('success-message','Item type deleted');
		return Redirect::to('item/type/view/delete');

	}

	public function updateView()
	{
		$itemtype = Itemtype::all();
		return View::make('item.type.update-view')
			->with('itemtype',$itemtype)
			->with('active_tab','update');
	}

	public function deleteView()
	{

		$itemtype = Itemtype::all();
		return View::make('item.type.remove-view')
			->with('itemtype',$itemtype)
			->with('active_tab','remove');
	}

	public function restoreView()
	{
		$itemtype = Itemtype::onlyTrashed()->get();
		return View::make('item.type.restore-view')
			->with('itemtype',$itemtype)
			->with('active_tab','restore');
	}

	public function restore($id)
	{
		$itemtype = Itemtype::onlyTrashed()->where('id',$id)->first();
		$itemtype->restore();

		Session::flash('success-message','Item type restored');
		return Redirect::to('item/type/view/restore');
	}

	public function getAllItemTypes()
	{
		if(Request::ajax())
		{
			$workstation = Input::get('workstation');
			if($workstation === 'workstation'){
				$itemtype = Itemtype::where('name','!=','System Unit')
															->where('name','!=','Display')
															->where('name','!=','AVR')
															->where('name','!=','Keyboard')
															->get();
			}else{
				$itemtype = Itemtype::all();
			}
			return json_encode($itemtype);
		}
	}

}
