<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePcTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pc', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('systemunit_id')->unsigned();
			$table->foreign('systemunit_id')->references('id')->on('itemprofile');
			$table->integer('monitor_id')->unsigned();
			$table->foreign('monitor_id')->references('id')->on('itemprofile');
			$table->integer('keyboard_id')->unsigned();
			$table->foreign('keyboard_id')->references('id')->on('itemprofile');
			$table->integer('avr_id')->unsigned();
			$table->foreign('avr_id')->references('id')->on('itemprofile');
			$table->string('oskey');
			$table->boolean('mouse');
			



		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('pc');
	}

}
