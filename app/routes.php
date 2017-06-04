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

	Route::resource('dashboard','DashboardController',array('only'=>array('index')));

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
	Route::resource('inventory/item','ItemInventoryController',[
		'except' => array('show')
	]);

	Route::get('inventory/item/{id}/add',[
		'as' => 'inventory.item.add',
		'uses'=>'ItemInventoryController@add'
	]);

	/*
	|--------------------------------------------------------------------------
	| Ticket
	|--------------------------------------------------------------------------
	|
	*/
	Route::resource('ticket','TicketsController',[
		'except'=>array('show')
	]);



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
	Route::resource('workstation', 'WorkstationController',[
		'except' => array('show')
	]);
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
	//workstation per software
	Route::get('workstation/view/software','WorkstationSoftwareController@index');
	//workstation per software
	Route::get('workstation/software/{id}/assign','WorkstationSoftwareController@create');
	//workstation per software
	Route::get('workstation/software/{id}/remove','WorkstationSoftwareController@destroyView');
	//workstation per software
	Route::delete('workstation/software/{id}/remove',[
		'as' => 'workstation.software.destroy',
		'uses' => 'WorkstationSoftwareController@destroy'
	]);
	//workstation per software
	Route::post('workstation/software/{id}/assign',[
			'as' => 'workstation.software.assign',
			'uses' => 'WorkstationSoftwareController@store'
	]);

	Route::get('workstation/form/deployment',[
		'as' => 'workstation.form.deployment',
		'uses' => 'WorkstationController@deployment'
	]);

	Route::post('workstation/deploy',[
		'as' => 'workstation.deploy',
		'uses' => 'WorkstationController@deploy'
	]);

	Route::get('workstation/view/transfer',[
		'as' => 'workstation.view.transfer',
		'uses' => 'WorkstationController@transferView'
	]);

	Route::post('workstation/transfer',[
		'as' => 'workstation.transfer',
		'uses' => 'WorkstationController@transfer'
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

	/*
	|--------------------------------------------------------------------------
	| Equipment support
	|--------------------------------------------------------------------------
	|
	*/

	Route::resource('equipment/support','EquipmentSupportController');

	Route::get('equipment/support/view/update',[
		'as' => 'equipment.support.view.update',
		'uses' => 'EquipmentSupportController@updateView'
	]);

	Route::get('equipment/support/view/delete',[
		'as' => 'equipment.support.view.delete',
		'uses' => 'EquipmentSupportController@deleteView'
	]);

	/*
	|--------------------------------------------------------------------------
	| Items for reservation
	|--------------------------------------------------------------------------
	|
	*/
	Route::resource('reservation/items/list','ReservationItemsController',[
			'except' => array('show')
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
	Route::get('get/item/type/all',[
		'as' => 'item.type.all',
		'uses'=>'ItemTypesController@getAllItemTypes'
	]);
	//change user password
	//used in Change Password -> account update
	Route::post('changeUserPassword','AccountsController@changeUserPassword');
	//activate account ( not used )
	Route::post('activateAccount','AccountsController@activateAccount');
	//returns a list of A.R. based on 'id' given
	//used in Select Box -> Item Profile
	Route::get('get/item/profile/receipt/all',[
		'as'=>'item.profile.receipt.all',
		'uses'=>'ItemsAjaxController@getAllReceipt'
	]);
	//get all license types for the software
	//uses softwarecontroller
	Route::get('get/software/license/all',[
		'as'=>'software.license.all',
		'uses'=>'SoftwareController@getAllLicenseTypes'
	]);
	//get all software types for the software
	//uses softwarecontroller
	Route::get('get/software/type/all',[
		'as'=>'software.type.all',
		'uses'=>'SoftwareController@getAllSoftwareTypes'
	]);
	//returns list of brands
	//uses ItemsController
	Route::get('get/item/brand/all',[
		'as' => 'inventory.item.brand.all',
		'uses' => 'ItemsAjaxController@getItemBrands'
	]);
	//returns list of Models
	//uses ItemsController
	Route::get('get/item/model/all',[
		'as' => 'inventory.item.model.all',
		'uses' => 'ItemsAjaxController@getItemModels'
	]);
	//returns list of propertynumber
	//uses ItemsInventoryController
	Route::get('get/item/propertynumber/server',[
		'as' => 'inventory.item.propertynumber.server',
		'uses' => 'ItemsAjaxController@getPropertyNumberOnServer'
	]);

	/*
	|--------------------------------------------------------------------------
	| ajax request returns reserved items
	|--------------------------------------------------------------------------
	|
	*/

	Route::get('reservation/view/all',[
		'as' => 'reservation.view.all',
		'uses' => 'ReservationController@index'
	]);

	/*
	|--------------------------------------------------------------------------
	| item profile ajax request
	|--------------------------------------------------------------------------
	|
	*/

	Route::get('get/item/profile/systemunit/unassigned',[
		'as' => 'item.profile.systemunit.unassigned',
		'uses' => 'ItemsAjaxController@getUnassignedSystemUnit'
	]);

	Route::get('get/item/profile/monitor/unassigned',[
		'as' => 'item.profile.monitor.unassigned',
		'uses' => 'ItemsAjaxController@getUnassignedMonitor'
	]);

	Route::get('get/item/profile/avr/unassigned',[
		'as' => 'item.profile.avr.unassigned',
		'uses' => 'ItemsAjaxController@getUnassignedAVR'
	]);

	Route::get('get/item/profile/keyboard/unassigned',[
		'as' => 'item.profile.keyboard.unassigned',
		'uses' => 'ItemsAjaxController@getUnassignedKeyboard'
	]);
	Route::get('get/workstation/tableform/undeployed',[
		'as' => 'workstation.tableform.undeployed',
		'uses' => 'WorkstationAjaxController@getUndeployedWorkstationInTableForm'
	]);
	Route::get('get/workstation/tableform/all/location',[
		'as' => 'workstation.tableform.all.location',
		'uses' => 'WorkstationAjaxController@getAllWorkstationInTableFormWithLocation'
	]);
	Route::get('get/equipment/support/all',[
		'as' => 'equipment.support.all',
		'uses' => 'EquipmentSupportAjaxController@getAllEquipmentSupport'
	]);

	Route::get('get/ticket/type/all',[
		'as' => 'ticket.type.all',
		'uses' => 'TicketTypeAjaxController@getAllTicketTypes'
	]);

	Route::get('get/equipment/support/preventive',[
		'as' => 'ticket.type.preventive',
		'uses' => 'EquipmentSupportAjaxController@getPreventiveEquipmentSupport'
	]);

	Route::get('get/equipment/support/corrective',[
		'as' => 'ticket.type.corrective',
		'uses' => 'EquipmentSupportAjaxController@getCorrectiveEquipmentSupport'
	]);

	Route::get('get/room/inventory/{id}',[
		'as' => 'room.inventory.profile',
		'uses' => 'RoomInventoryProfileController@getItemsAssigned'
	]);

	Route::get('get/room/name/{id}',[
		'as' => 'room.name',
		'uses' => 'RoomsAjaxController@getRoomName'

	]);

	Route::get('get/software/installed/{id}',[
		'as' => 'workstation.pc.software',
		'uses' => 'WorkstationSoftwareAjaxController@getSoftwareInstalled'
	]);

	Route::get('get/reservation/items/list/all',[
		'as' => 'reservation.items.list.all',
		'uses' => 'ReservationItemsAjaxController@getAllReservationItemList'
	]);

	Route::get('get/reservation/item/type/all',[
		'as' => 'reservation.item.type.all',
		'uses' => 'ReservationItemsAjaxController@getAllReservationItemType'
	]);

	Route::get('get/reservation/item/brand/all',[
		'as' => 'reservation.item.brand.all',
		'uses' => 'ReservationItemsAjaxController@getAllReservationItemBrand'
	]);

	Route::get('get/reservation/item/model/all',[
		'as' => 'reservation.item.model.all',
		'uses' => 'ReservationItemsAjaxController@getAllReservationItemModel'
	]);

	Route::get('get/reservation/item/propertynumber/all',[
		'as' => 'reservation.item.propertynumber.all',
		'uses' => 'ReservationItemsAjaxController@getAllReservationItemPropertyNumber'
	]);

	Route::post('update/reservation/items/list/status/{id}',[
		'as' => 'update.reservation.items.list.status',
		'uses' => 'ReservationItemsAjaxController@updateReservationItemListStatus'
	]);

	Route::get('get/software/all/name',[
		'as' => 'software.all.name',
		'uses' => 'SoftwareAjaxController@getAllSoftwareName'
	]);

	Route::get('get/software/license/{id}/key',[
		'as' => 'software.license.all.key',
		'uses' => 'SoftwareLicenseAjaxController@getAllSoftwareLicenseKey'
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
