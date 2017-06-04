<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceiptTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('receipt', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('number',25);
			$table->integer('inventory_id')->unsigned();
			$table->foreign('inventory_id')->references('id')->on('inventory');
			$table->string('POno',25)->nullable();
			$table->date('POdate')->nullable();
			$table->string('invoiceno',25)->nullable();
			$table->date('invoicedate')->nullable();
			$table->string('fundcode',25)->nullable();
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
		Schema::drop('receipt');
	}

}
