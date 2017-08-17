<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reservation', function(Blueprint $table)
		{	
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('user');
			$table->datetime('timein');
			$table->datetime('timeout');
			$table->string('purpose',100);
			$table->string('location',100);
			$table->boolean('approval');
			$table->string('facultyincharge',100)->nullable();
			$table->string('remark',100)->nullable();
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
		Schema::drop('reservation');
	}

}
