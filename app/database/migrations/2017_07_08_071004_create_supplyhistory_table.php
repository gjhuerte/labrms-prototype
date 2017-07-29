<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplyhistoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('supplyhistory', function(Blueprint $table)
		{
            $table->integer('supply_id')->unsigned();
			$table->foreign('supply_id')->references('id')->on('supply')
										->onDelete('cascade');;
            $table->integer('quantity');
            $table->string('remark');
			$table->string('personinvolve');
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
		Schema::drop('supplyhistory');
	}

}
