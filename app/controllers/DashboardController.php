<?php

class DashboardController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// if(Auth::user()->accesslevel == '0' || Auth::user()->accesslevel == '1')
		// {
		// 	Paginator::setPageName('ticket');
		// 	$tickets = Ticket::withTrashed()->where('created_at','>=',Carbon\Carbon::now()->subDays(8)->toDateString())->orderBy('created_at','asc')->paginate(4);
		// 	Paginator::setPageName('reservation');
		// 	$reservations = Reservation::where('dateofuse','>=',Carbon\Carbon::now()->toDateString())->paginate(8);
		// 	Paginator::setPageName('roomlog');
		// 	$roomlog = Roomlog::where('created_at','>=',Carbon\Carbon::now()->toDateString())->paginate(4);
		// 	return View::make('dashboard.admin.index')
		// 		->with('tickets',$tickets)
		// 		->with('reservations',$reservations)
		// 		->with('roomlogs',$roomlog);

		// }else
		// {
		// 	Paginator::setPageName('ticket');
		// 	$tickets = Ticket::withTrashed()->where('clientname','=',Auth::user()->username)->orderBy('created_at','desc')->paginate(4);
		// 	Paginator::setPageName('reservation');
		// 	$reservations = Reservation::withTrashed()->where('user_id','=',Auth::user()->id)->orderBy('dateofuse','desc')->paginate(4);
		// 	return View::make('dashboard.user.index')
		// 		->with('tickets',$tickets)
		// 		->with('reservations',$reservations)
		// 		->with('reservation_all',Reservation::withTrashed()->get());

		// }

		return View::make('dashboard.admin.index');
	}


}
