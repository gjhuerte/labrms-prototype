<?php

class WorkstationSoftwareAjaxController extends \BaseController {

	public function getSoftwareInstalled($id)
	{
		if(Request::ajax())
		{
			$pcsoftware = Pcsoftware::leftJoin('software','pc_software.software_id','=','software.id')
										->leftJoin('softwarelicense','pc_software.softwarelicense_id','=','softwarelicense.id')
										->where('pc_software.pc_id',$this->sanitizeString($id))
										->select('softwarename','key')
										->get();
			return json_encode($pcsoftware);
		}
	}

}
