<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoftwareTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('software', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('softwarename',100);
			$table->string('softwaretype',100);
			$table->string('licensetype',100);
			$table->string('company',100);
			$table->string('minsysreq',100)->nullable();//minimum system requirements
			$table->string('maxsysreq',100)->nullable();//maxsystemrequirements
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
		Schema::drop('software');
	}

}
