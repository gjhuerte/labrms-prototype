<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomsoftwareTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('roomsoftware', function(Blueprint $table)
		{
			$table->integer('room_id')->unsigned();
			$table->foreign('room_id')->references('id')->on('room');
			$table->integer('software_id')->unsigned();
			$table->foreign('software_id')->references('id')->on('software');
			$table->integer('softwarelicense_id')->unsigned()->nullable();
			$table->foreign('softwarelicense_id')->references('id')->on('softwarelicense');
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
		Schema::drop('roomsoftware');
	}

}
