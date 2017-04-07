<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoftwarelistTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('softwarelist', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name',100);
			$table->string('description',450);
			$table->string('licensetype',100);
			$table->string('requirement',100);
			$table->string('softwaretype',50);
			$table->foreign('softwaretype')->references('type')->on('softwaretype');
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
		Schema::drop('softwarelist');
	}

}
