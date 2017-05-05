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
			$table->integer('inventory_id')->unsigned();
			$table->foreign('inventory_id')->references('id')->on('inventory');
			$table->integer('receipt_id')->unsigned();
			$table->foreign('receipt_id')->references('id')->on('receipt');
			$table->string('propertynumber',100)->nullable();
			$table->string('serialnumber',100)->nullable();
			$table->string('location',100);
			$table->date('datereceived')->nullable();
			$table->string('status',100);
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
		Schema::drop('itemprofile');
	}

}
