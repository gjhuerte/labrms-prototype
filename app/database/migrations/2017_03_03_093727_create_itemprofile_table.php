<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemprofileTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('itemprofile', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('serialid',100);
			$table->string('property_number',100);
			/*$table->integer('type');*/
			$table->string('type',50);
			$table->foreign('type')->references('type')->on('itemtype');
			$table->string('MR_no',50);
			$table->string('status',50);
			$table->string('description',100);
			$table->string('location',100);
			$table->integer('inventory_id')->unsigned();
			$table->foreign('inventory_id')->references('id')->on('inventory');
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
		Schema::drop('itemprofile');
	}

}
