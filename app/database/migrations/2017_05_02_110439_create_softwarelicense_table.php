<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoftwarelicenseTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('softwarelicense', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('software_id')->unsigned();
			$table->foreign('software_id')->references('id')->on('software');
			$table->string('key',100);
			$table->boolean('multipleuse');//true if the key can be used again on other pc
			$table->boolean('inuse');//true if the key is already in use
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
		Schema::drop('softwarelicense');
	}

}
