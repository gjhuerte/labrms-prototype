<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemReservationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('item_reservation', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('reservation_id')->unsigned();
			$table->foreign('reservation_id')->references('id')->on('reservation');
			$table->integer('item_id')->unsigned();
			$table->foreign('item_id')->references('id')->on('itemprofile');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('item_reservation');
	}

}
