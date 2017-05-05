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
			$table->integer('log_id')->unsigned();
			$table->foreign('log_id')->references('id')->on('log');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('user');
			$table->integer('room_id')->unsigned();
			$table->foreign('room_id')->references('id')->on('room');
			$table->string('workingunits',100);//number of working units
			$table->string('section',20);
			$table->string('remark',100)->nullable();
			$table->timestamps();
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
		Schema::drop('roomlog');
	}

}
