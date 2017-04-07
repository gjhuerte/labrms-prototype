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
			$table->string('name',20)->unique();
			$table->integer('systemunit_id')->unsigned();
			$table->foreign('systemunit_id')->references('id')->on('itemprofile');
			$table->integer('display_id')->unsigned();
			$table->foreign('display_id')->references('id')->on('itemprofile');
			$table->boolean('keyboard');
			$table->boolean('mouse');
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
		Schema::drop('pc');
	}

}
