<?php

class TicketTypeAjaxController extends \BaseController {

	public function getAllTicketTypes()
	{
		return json_encode(Tickettype::select('type')->get()->sortBy('type'));
	}

}
