<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ticket', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('item_id')->unsigned()->nullable();
			$table->foreign('item_id')->references('id')->on('itemprofile');/*,'pc','room'*/
			$table->string('title',100);
			$table->string('type',50);
			$table->string('clientname',100);
			$table->string('description',450);
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
		Schema::drop('ticket');
	}

}
