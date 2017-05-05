<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePcsoftwareTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pcsoftware', function(Blueprint $table)
		{
			$table->integer('pc_id')->unsigned();
			$table->foreign('pc_id')->references('id')->on('pc');
			$table->integer('software_id')->unsigned();
			$table->foreign('software_id')->references('id')->on('softwarelist');
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
		Schema::drop('pcsoftware');
	}

}
