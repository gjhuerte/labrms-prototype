<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplyTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('supply', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('itemtype_id')->unsigned();
			$table->foreign('itemtype_id')->references('id')->on('itemtype')
										->onDelete('cascade');;
            $table->string('brand');
            $table->string('unit');
            $table->integer('quantity');
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
		Schema::drop('supply');
	}

}
