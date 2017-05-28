<?php

class WorkstationAjaxController extends \BaseController {

	public function getUndeployedWorkstationInTableForm()
	{
		$room = Room::where('name','Server')->select('id')->first();
		$id = Roominventory::where('room_id','!=',$room->id)
						->select('item_id')
						->lists('item_id');
		$workstation = Pc::whereNotIn('systemunit_id',$id)
											->whereNotIn('monitor_id',$id)
											->whereNotIn('keyboard_id',$id)
											->whereNotIn('avr_id',$id)
											->get();

		$rows = "";

		foreach($workstation as $workstation){
				$mouse = 'No';
				($workstation->mouse == 1) ? $mouse = 'Yes': '';
				$systemunit = $workstation->systemunit;
				$monitor = $workstation->monitor;
				$keyboard = $workstation->keyboard;
				$avr = $workstation->avr;
				$rows .= "<tr>
					<td>$workstation->id</td>
					<td>$systemunit->propertynumber</td>
					<td>$monitor->propertynumber</td>
					<td>$avr->propertynumber</td>
					<td>$keyboard->propertynumber</td>
					<td>$mouse</td>
				</tr>";
		}

		return $rows;
	}

	public function getAllWorkstationInTableFormWithLocation()
	{
		$room = Room::where('name','Server')->select('id')->first();
		$id = Roominventory::where('room_id','!=',$room->id)
						->select('item_id')
						->lists('item_id');
		$workstation = Pc::all();

		$rows = "";

		foreach($workstation as $workstation){
			
				($workstation->mouse == 1) ? $mouse = 'Yes': $mouse = 'No';
				$systemunit = $workstation->systemunit;
				$monitor = $workstation->monitor;
				$keyboard = $workstation->keyboard;
				$avr = $workstation->avr;

				$roomname = $systemunit->location;

				$rows .= "<tr>
					<td>$workstation->id</td>
					<td>$systemunit->propertynumber</td>
					<td>$monitor->propertynumber</td>
					<td>$avr->propertynumber</td>
					<td>$keyboard->propertynumber</td>
					<td>$mouse</td>
					<td>$roomname</td>
				</tr>";
		}

		return $rows;
	}

}
