<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('item_log', function(Blueprint $table)
		{
			$table->integer('log_id')->unsigned();
			$table->foreign('log_id')->references('id')->on('log');
			$table->integer('item_id')->unsigned();
			$table->foreign('item_id')->references('id')->on('pc');
			$table->string('facultyincharge',100)->nullable();
			$table->string('remark',200)->nullable();
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
		Schema::drop('itemlog');
	}

}
