<?php 

class ReportsController extends \BaseController {
	
	public function getIncidentList()
	{
		return View::make('report.incident')
			->with('incident',Ticket::where('type','in','("incident","complaint")')->get());
	}

	public function getItemList()
	{
		return View::make('report.item')
			->with('inventory',Inventory::all());
	}

	public function getItemProfile()
	{
		return View::make('report.itemprofile')
			->with('itemprofile',Itemprofile::all());
	}

	public function getLog()
	{
		return View::make('report.log')
			->with('lendlog',Lendlog::all());
	}

	public function getRoomInventory()
	{
		return View::make('report.roominventory')
			->with('room',Room::all());
	}

	public function getPayment()
	{
		return View::make('report.payment')
			->with('payment',Payment::all());
	}


}
