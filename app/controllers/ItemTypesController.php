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
					'data' => Itemtype::select('id','name','description','category')->get()
				]);
		}

		return View::make('item.type.index');
	}

	public function create()
	{
		return View::make('item.type.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$name = $this->sanitizeString(Input::get('name'));
		$description = $this->sanitizeString(Input::get('description'));
		$category = $this->sanitizeString(Input::get('category'));

		$validator = Validator::make([
			'name' => $name,
			'description' => $description
		],ItemType::$rules);

		if($validator->fails())
		{
			return Redirect::to('item/type/create')
				->withInput()
				->withErrors($validator);
		}

		ItemType::createRecord($name,$description,$category);

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
		$category = $this->sanitizeString(Input::get('category'));

		$validator = Validator::make([
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
		$itemtype->category = $category;
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
