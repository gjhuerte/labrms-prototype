<?php

class SoftwareLicenseAjaxController extends \BaseController {

	public function getAllSoftwareLicenseKey($id)
	{
		if(Request::ajax())
		{
			$id = $this->sanitizeString($id);
			$software = Software::find($id);
			$softwarelicense = Softwarelicense::where('id',$software->id)
																->select('id','key')->get();
			return json_encode($softwarelicense);
		}
	}

}
