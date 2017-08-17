<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaintenanceactivityitemtypeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('maintenanceactivity_itemtype', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('maintenanceactivity_id')->references('id')->on('maintenanceactivity')->onDelete('cascade');
			$table->string('itemtype_id')->references('id')->on('itemtype')->onDelete('cascade');
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
		Schema::drop('maintenanceactivity_itemtype');
	}

}
