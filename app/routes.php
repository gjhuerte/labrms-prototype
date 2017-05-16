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

/*
|--------------------------------------------------------------------------
| Accessible urls of all users
|--------------------------------------------------------------------------
|
*/
Route::group(['before'=>'auth'],function(){

	Route::resource('dashboard','DashboardController');

	Route::resource('reservation','ReservationController',array('only'=>array('create','store')));

	Route::get('profile',['as'=>'profile.index','uses'=>'SessionsController@show']);

	Route::get('settings',['as'=>'settings.edit','uses'=>'SessionsController@edit']);

	Route::post('settings',['as'=>'settings.update','uses'=>'SessionsController@update']);

	Route::get('logout','SessionsController@destroy');

});

/*
|--------------------------------------------------------------------------
| Ajax Request by all users
|--------------------------------------------------------------------------
|
*/
Route::group(['before'=>'auth'],function(){


});

/*
|--------------------------------------------------------------------------
| Administrator's access only
|--------------------------------------------------------------------------
|
*/
Route::group(['before'=>'auth|admin'], function () {

/*
|--------------------------------------------------------------------------
| Account Maintenance
|--------------------------------------------------------------------------
|
*/
	//Display all accounts
	Route::resource('account','AccountsController');

	//update view of all accounts
	Route::get('account/view/update',[
			'as'=>'account.view.update',
			'uses' => 'AccountsController@updateView'
		]);

	//delete view of all accounts
	Route::get('account/view/delete',[
			'as'=>'account.view.delete',
			'uses' => 'AccountsController@deleteView'
		]);

	//retrieve all inactive accounts
	Route::get('account/view/activation',[
			'as'=>'account.retrieveInactiveAccount',
			'uses'=>'AccountsController@retrieveInactiveAccount'
		]);

	//activate or deactivate accounts
	Route::post('account/view/activation',[
			'as'=>'account.activate',
			'uses'=>'AccountsController@activateAccount'
		]);

	//display all deleted accounts
	//for account restoration
	Route::get('account/view/deleted',[
			'as'=>'account.retrieveDeleted',
			'uses'=>'AccountsController@retrieveDeleted'
		]);

	//restore account
	Route::delete('account/view/deleted/{id}',[
			'as'=>'account.restore',
			'uses'=>'AccountsController@restore'
		]);

/*
|--------------------------------------------------------------------------
| Room Maintenance
|--------------------------------------------------------------------------
|
*/
	//crud for room
	Route::resource('room','RoomsController');
	//display all rooms for update
	Route::get('room/view/update',[
			'as' => 'room.view.update',
			'uses' => 'RoomsController@updateView'
		]);

	//display all rooms for delete
	Route::get('room/view/delete',[
			'as' => 'room.view.delete',
			'uses' => 'RoomsController@deleteView'
		]);

	//display deleted rooms
	Route::get('room/view/restore',[
		'as'=>'room.view.restore',
		'uses'=>'RoomsController@restoreView'
	]);
	//restore
	Route::put('room/view/restore/{id}',[
		'as'=>'room.restore',
		'uses'=>'RoomsController@restore'
	]);

/*
|--------------------------------------------------------------------------
| Faculty Maintenance
|--------------------------------------------------------------------------
|
*/

	//crud for faculty
	Route::resource('faculty','FacultyController');

	//display all faculty for update
	Route::get('faculty/view/update',[
			'as' => 'faculty.update-view',
			'uses' => 'FacultyController@updateView'
		]);

	//display all faculty for deletion
	Route::get('faculty/view/delete',[
			'as' => 'faculty.delete-view',
			'uses' => 'FacultyController@deleteView'
		]);

/*
|--------------------------------------------------------------------------
| Inventory Maintenance
|--------------------------------------------------------------------------
|
*/
	//crud for item
	Route::resource('inventory/item','ItemInventoryController');

/*
|--------------------------------------------------------------------------
| Ticket
|--------------------------------------------------------------------------
|
*/
	Route::resource('ticket','TicketsController');



/*
|--------------------------------------------------------------------------
| Reports
|--------------------------------------------------------------------------
|
*/
	Route::get('report','ReportsController@index');
    // ... another resource ...

/*
|--------------------------------------------------------------------------
| Item Profiling
|--------------------------------------------------------------------------
|
*/
	Route::resource('item/profile','ItemsController');
/*
|--------------------------------------------------------------------------
| Room Inventory
|--------------------------------------------------------------------------
|
*/
	// room inventory crud
	Route::resource('inventory/room','RoomInventoryController',array('except'=>array('show')));

	// room inventory assignment
	Route::resource('inventory/room/assign','RoomInventoryAssignmentController',array('only' => array('index','store')));
	// room inventory view
	Route::resource('inventory/room/profile','RoomInventoryProfile');
/*
|--------------------------------------------------------------------------
| Software
|--------------------------------------------------------------------------
|
*/
	Route::resource('software','SoftwareController');
	//display software update table
	Route::get('software/view/update',
	[
		'as'=>'software.view.edit',
		'uses'=>'SoftwareController@updateView'
	]);
	//display software update view
	Route::post('software/view/update',[
		'as'=>'software.view.update',
		'uses'=>'SoftwareController@updateView'
	]);
	//display software delete table
	Route::get('software/view/delete',[
		'as'=>'software.view.delete',
		'uses'=>'SoftwareController@deleteView'
	]);
	//display software restore table
	Route::get('software/view/restore',[
		'as'=>'software.view.restore',
		'uses'=>'SoftwareController@restoreView'
	]);
	//restore
	Route::post('software/view/restore/{id}',[
		'as'=>'software.restore',
		'uses'=>'SoftwareController@restore'
	]);
/*
|--------------------------------------------------------------------------
| Workstation
|--------------------------------------------------------------------------
|
*/
	Route::resource('workstation', 'WorkstationController');
	//display workstation update table
	Route::get('workstation/view/update',[
		'as' => 'workstation.view.update',
		'uses' => 'WorkstationController@updateView'
	]);
	//display workstation delete table
	Route::get('workstation/view/delete',[
		'as' => 'workstation.view.delete',
		'uses' => 'WorkstationController@deleteView'
	]);
	//display workstation restore table
	Route::get('workstation/view/restore',[
		'as' => 'workstation.view.restore',
		'uses' => 'WorkstationController@restoreView'
	]);
	//restore
	Route::post('workstation//view/restore/{id}',[
		'as' => 'workstation.restore',
		'uses' => 'WorkstationController@restore'
	]);
/*
|--------------------------------------------------------------------------
| Software
|--------------------------------------------------------------------------
|
*/
	Route::resource('item/type','ItemTypesController');
	//update table
	Route::get('item/type/view/update',[
		'as' => 'item.type.view.update',
		'uses' => 'ItemTypesController@updateView'
	]);
	//delete table
	Route::get('item/type/view/delete',[
			'as' => 'item.type.view.delete',
			'uses' => 'ItemTypesController@deleteView'
		]);
	//restore table
	Route::get('item/type/view/restore',[
		'as' => 'item.type.view.restore',
		'uses' => 'ItemTypesController@restoreView'
	]);
	//restore
	Route::post('item/type/view/restore/{id}',[
		'as' => 'item.type.restore',
		'uses' => 'ItemTypesController@restore'
	]);
});
/*
|--------------------------------------------------------------------------
| Ajax Request made by admin only
|--------------------------------------------------------------------------
|
*/
Route::group(['before'=>'auth|admin'], function () {

	//fetch a field using ajax ( not used )
	Route::post('getItemField','ItemInventoryController@getItemField');
	//get all item types ( not used )
	Route::get('get/item/type/all','ItemTypesController@getAllItemTypes');
	//change user password
	//used in Change Password -> account update
	Route::post('changeUserPassword','AccountsController@changeUserPassword');
	//activate account ( not used )
	Route::post('activateAccount','AccountsController@activateAccount');
	//returns a list of A.R. based on 'id' given
	//used in Select Box -> Item Profile
	Route::get('returnListOfReceipt',[
		'as'=>'item.profile.returnListOfReceipt',
		'uses'=>'ItemsController@returnListOfReceipt'
	]);
	//get all license types for the software
	//uses softwarecontroller
	Route::get('getLicenseTypes',[
		'as'=>'software.getLicenseType',
		'uses'=>'SoftwareController@getLicenseTypes'
	]);
	//get all software types for the software
	//uses softwarecontroller
	Route::get('getSoftwareTypes',[
		'as'=>'software.getSoftwareType',
		'uses'=>'SoftwareController@getSoftwareTypes'
	]);
	//returns list of brands
	//uses ItemsController
	Route::get('get/item/brand/all',[
		'as' => 'inventory.item.brand.all',
		'uses' => 'ItemsController@getItemBrands'
	]);
	//returns list of Models
	//uses ItemsController
	Route::get('get/item/model/all',[
		'as' => 'inventory.item.model.all',
		'uses' => 'ItemsController@getItemModels'
	]);
	//returns list of propertynumber
	//uses ItemsInventoryController
	Route::get('get/item/propertynumber/server',[
		'as' => 'inventory.item.propertynumber.server',
		'uses' => 'ItemsController@getPropertyNumberOnServer'
	]);

/*
|--------------------------------------------------------------------------
| Reservation View
|--------------------------------------------------------------------------
|
*/

	Route::get('reservation/view/all',[
		'as' => 'reservation.view.all',
		'uses' => 'ReservationController@index'
	]);
});

/*
|--------------------------------------------------------------------------
| Main Menu
|--------------------------------------------------------------------------
|
*/
Route::group(['before'=>'session_start'], function () {
	//display homepage
	Route::get('/','HomeController@index');
	//display login page
	Route::get('login', ['as'=>'login.index','uses'=>'SessionsController@create']);
	//send login request
	Route::post('login', ['as'=>'login.store','uses'=>'SessionsController@store']);
	//reset
	Route::get('reset',['as'=>'reset','uses'=>'SessionsController@getResetForm']);
	//send reset
	Route::post('reset',['as'=>'reset.store','uses'=>'SessionsController@reset']);
});

//page not found
Route::get('pagenotfound',['as'=>'pagenotfound','uses'=>'HomeController@pagenotfound']);
