<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('schedule', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('room_id')->unsigned();
			$table->foreign('room_id')->references('id')->on('room');
			$table->string('day',50);
			$table->time('timein');
			$table->time('timeout');
			$table->string('facultyincharge',100);
			$table->string('courseyearsection',100);
			$table->string('subject',100);
			$table->string('semester',100);
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
		Schema::drop('schedule');
	}

}
