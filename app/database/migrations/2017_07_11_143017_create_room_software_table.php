<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomSoftwareTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('room_software', function(Blueprint $table)
		{
			$table->integer('room_id')->unsigned();
			$table->foreign('room_id')->references('id')->on('room');
			$table->integer('software_id')->unsigned()
										->onDelete('cascade');
			$table->foreign('software_id')->references('id')->on('software')
										->onDelete('cascade');
			$table->integer('softwarelicense_id')->unsigned()->nullable();
			$table->foreign('softwarelicense_id')->references('id')->on('softwarelicense');
			$table->primary(array('room_id','software_id'));
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
		Schema::drop('room_software');
	}

}
