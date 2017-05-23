<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationitemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reservationitems', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('itemtype_id')->unsigned();
			$table->integer('inventory_id')->unsigned();
			$table->integer('included')->nullable();
			$table->string('excluded')->nullable();
			$table->string('status')->nullable();
			$table->foreign('itemtype_id')->references('id')->on('itemtype');
			$table->foreign('inventory_id')->references('id')->on('inventory');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('reservationitems');
	}

}
