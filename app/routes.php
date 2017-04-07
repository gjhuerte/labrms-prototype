<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::group(['before'=>'auth'],function(){

	Route::resource('dashboard','DashboardController');

	Route::get('reservation/create','ReservationController@create');

	Route::post('reservation',['as' => 'reservation.store','uses'=>'ReservationController@store']);

	Route::get('reservation/{id}',['as'=>'reservation.show','uses'=>'ReservationController@show']);	

	Route::get('profile',['as'=>'profile.index','uses'=>'UsersController@index']);

	Route::get('settings',['as'=>'settings.edit','uses'=>'UsersController@edit']);

	Route::post('settings',['as'=>'settings.update','uses'=>'UsersController@update']);

	Route::get('logout','SessionsController@destroy');

});

// ajax request
Route::group(['before'=>'auth'],function(){

	Route::post('getAllItemsAssignedToThisRoom','RoomsController@getAllItems');
	
	Route::post('getAllPropertyNumber','ReservationController@getItemList');

	Route::post('getAllItemName','ReservationController@getItemName');

});


Route::group(['before'=>'auth|admin'], function () {

	//maintenance 

	Route::resource('account','AccountsController');

	Route::resource('room','RoomsController');

	Route::resource('room/log','RoomLogController');

	Route::resource('supplies','SuppliesController');

	Route::resource('schedule','ScheduleController');

	Route::resource('software','SoftwareController');

	Route::resource('faculty','FacultyController');

	Route::post('getAllWorkstation','SoftwareController@getWorkstationByRoom');
	
	Route::resource('item/type','ItemTypesController');

	Route::resource('workstation','WorkstationController');

	Route::resource('inventory/item','ItemInventoryController');

	Route::get('inventory/item/add','ItemInventoryController@add');

	Route::resource('inventory/room','RoomInventoryController');

	Route::resource('item/profile','ItemsController');

	Route::resource('equipment','EquipmentsController');

	Route::get('lend/approval','LendController@approve');

	// reservation
	Route::get('reservation',['as'=>'reservation.index','uses'=>'ReservationController@index']);

	Route::put('reservation/{id}',['as'=>'reservation.update','uses'=>'ReservationController@update']);

	Route::delete('reservation/{reservation}',['as'=>'reservation.destroy','uses'=>'ReservationController@destroy']);
	Route::get('lend',['as'=>'lend.index','uses'=>'LendController@index']);

	Route::put('lend/approve',['as'=>'lend.update','uses'=>'LendController@update']);

	Route::get('borrow',['as'=>'lend.create','uses'=>'LendController@create']);
	
	Route::post('borrow',['as'=>'lend.store','uses'=>'LendController@store']);

	Route::get('lend/create',['as'=>'lend.create','uses'=>'LendController@create']);

	Route::post('lend',['as'=>'lend.store','uses'=>'LendController@store']);

	Route::resource('ticket','TicketsController');
	
	// reports
	Route::get('report/incident','ReportsController@getIncidentList');
	Route::get('report/item','ReportsController@getItemList');
	Route::get('report/itemprofile','ReportsController@getItemProfile');
	Route::get('report/log','ReportsController@getLog');
	Route::get('report/roominventory','ReportsController@getRoomInventory');
	Route::get('report/payment','ReportsController@getPayment');
    // ... another resource ...
});


// ajax request
Route::group(['before'=>'auth|admin'], function () {
	Route::post('getItemField','ItemInventoryController@getItemField');
	Route::post('getAllItemTypes','ItemTypesController@getAllItemTypes');
});

Route::group(['before'=>'session_start'], function () {
	Route::resource('/','HomeController');
	Route::get('login', 'SessionsController@index');
	Route::post('login', 'SessionsController@store');
});
