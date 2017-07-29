<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemreservationviewTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("CREATE VIEW itemreservationview AS 
			SELECT u.lastname,u.firstname,i.propertynumber,r.timein,r.timeout,r.purpose,r.location,r.approval,r.facultyincharge,r.remark
			FROM item_reservation AS ir 
			JOIN reservation AS r ON ir.reservation_id = r.id 
			JOIN itemprofile AS i ON i.id = ir.item_id 
			JOIN user AS u ON r.user_id = u.id;");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement("DROP VIEW itemreservationview;");
	}

}
