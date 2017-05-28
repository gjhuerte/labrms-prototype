<?php

class ReservationItemsAjaxController extends \BaseController {

	public function getAllReservationItemList()
	{
		if(Request::ajax())
		{
			$reservationitems = Reservationitems::leftJoin('inventory','inventory.id','=','reservationitems.inventory_id')->leftJoin('itemtype','itemtype.id','=','reservationitems.itemtype_id')->select('reservationitems.id as id','itemtype.name as name','inventory.model as model','inventory.brand as brand','reservationitems.included as included','reservationitems.excluded as excluded','reservationitems.status as status')->get();
			return json_encode(['data'=>$reservationitems]);
		}
	}

	public function updateReservationItemListStatus($id)
	{
		$reservationitems = Reservationitems::find($id);
		if(count($reservationitems) > 0)
		{
			($reservationitems->status == 'Disabled')  ? $reservationitems->status = 'Enabled' : $reservationitems->status = 'Disabled';
			$reservationitems->save();
			return json_encode('success');
		}
	}

}
