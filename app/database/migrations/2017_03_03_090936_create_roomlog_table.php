<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomlogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('roomlog', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('room_id')->unsigned();
			$table->foreign('room_id')->references('id')->on('room');
			$table->string('facultyincharge',100);
			$table->datetime('timein');
			$table->datetime('timeout');
			$table->integer('workingunits');
			$table->string('section',100);
			$table->string('staffincharge',100);
			$table->softDeletes();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('roomlog');
	}

}
