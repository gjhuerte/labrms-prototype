<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('room_log', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('login_id')->nullable()->unsigned();
			$table->foreign('login_id')->references('id')->on('log');
			$table->integer('logout_id')->nullable()->unsigned();
			$table->foreign('logout_id')->references('id')->on('log');
			$table->integer('room_id')->unsigned();
			$table->foreign('room_id')->references('id')->on('room');
			$table->string('facultyincharge',100);
			$table->string('section',20);
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
		Schema::drop('room_log');
	}

}
