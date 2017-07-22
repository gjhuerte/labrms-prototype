<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('inventory', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('itemtype_id')->unsigned();
			$table->string('brand',100)->nullable();
			$table->string('model',100)->nullable();
			$table->string('details',1000)->nullable();
			$table->string('warranty',100)->nullable();
			$table->string('unit',20);
			$table->integer('quantity');
			$table->integer('profileditems');
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
		Schema::drop('inventory');
	}

}
