<?php

class MaintenanceActivityAjaxController extends \BaseController {

	public function getAllMaintenanceActivity()
	{

		return json_encode(['data'=>MaintenanceActivity::all()]);
	}

	public function getPreventiveMaintenanceActivity()
	{
		return json_encode(MaintenanceActivity::where('type','preventive')->select('problem')->get());
	}

	public function getCorrectiveMaintenanceActivity()
	{
		return json_encode(MaintenanceActivity::where('type','corrective')->select('problem')->get());
	}
}
