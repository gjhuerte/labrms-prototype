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
			$table->integer('item_id')->unsigned();
			$table->foreign('item_id')->references('id')->on('itemprofile');
			$table->string('tickettype',100);
			$table->string('ticketname',100);
			$table->string('details',500);
			$table->string('author',100);
			$table->string('staffassigned',100)->nullable();
			$table->integer('ticket_id')->unsigned()->nullable();
			$table->foreign('ticket_id')->references('id')->on('ticket');
			$table->string('status');
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
		Schema::drop('ticket');
	}

}
