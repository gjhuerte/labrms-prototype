<?php

class EquipmentSupportAjaxController extends \BaseController {

	public function getAllEquipmentSupport()
	{

		return json_encode(['data'=>Equipmentsupport::all()]);
	}

	public function getPreventiveEquipmentSupport()
	{
		return json_encode(Equipmentsupport::where('type','preventive')->select('problem')->get());
	}

	public function getCorrectiveEquipmentSupport()
	{
		return json_encode(Equipmentsupport::where('type','corrective')->select('problem')->get());
	}
}
