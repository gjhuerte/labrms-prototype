<?php

class RoomsAjaxController extends \BaseController {

	public function getRoomName($id)
	{
		$room = Room::find($id);
		return json_encode($room->name);
	}

}
