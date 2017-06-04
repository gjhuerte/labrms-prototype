<?php

class SoftwareAjaxController extends \BaseController {

	public function getAllSoftwareName()
	{
		if(Request::ajax())
		{
			$software = Software::select('id','softwarename as name')->get();
			return json_encode($software);
		}
	}

}
