<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePcTicketTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pc_ticket', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('pc_id')->unsigned();
			$table->foreign('pc_id')->references('id')->on('pc')
									->onDelete('cascade');
            $table->integer('ticket_id')->unsigned();
			$table->foreign('ticket_id')->references('id')->on('ticket')
									->onDelete('cascade');
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
		Schema::drop('pc_ticket');
	}

}
