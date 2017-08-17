<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomscheduleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('roomschedule', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('room_id')->unsigned();
			$table->foreign('room_id')->references('id')->on('room')
									->onDelete('cascade');
			$table->integer('faculty')->nullable();
			$table->string('academicyear');
			$table->string('semester');
			$table->string('day');
			$table->time('timein');
			$table->time('timeout');
			$table->string('subject');
			$table->string('section')->nullable(); 
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('roomschedule');
	}

}
