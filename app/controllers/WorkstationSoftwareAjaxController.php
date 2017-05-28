<?php

class WorkstationSoftwareAjaxController extends \BaseController {

	public function getSoftwareIntalled($pcid)
	{
		$pcsoftware = Pcsoftware::leftJoin('software','pc_software.software_id','=','software.id')
									->leftJoin('softwarelicense','pc_software.softwarelicense_id','=','softwarelicense.id')
									->get();
		return json_encode($pcsoftware);
	}

}
