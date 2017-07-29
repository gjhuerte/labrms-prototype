<?php

class SupplyAjaxController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function getMouseBrandList()
	{
		if(Request::ajax())
		{
			$mouse = $this->sanitizeString(Input::get('term'));
			return json_encode(
			Supply::whereHas('itemtype',function($query){
									$query->where('name','=','Mouse');
							})
							->where('brand','like','%'.$mouse.'%')
							->lists('brand')
			);
		}
	}


}
