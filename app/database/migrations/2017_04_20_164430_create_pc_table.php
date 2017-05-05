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
			$table->integer('keyboard_id')->unsigned()->nullable();
			$table->foreign('keyboard_id')->references('id')->on('itemprofile');
			$table->integer('avr_id')->unsigned()->nullable();
			$table->foreign('avr_id')->references('id')->on('itemprofile');
			$table->string('oskey',50)->nullable();
			$table->boolean('mouse')->nullable();
			$table->softDeletes();
			



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
