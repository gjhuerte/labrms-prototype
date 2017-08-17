<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('log', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();//staff in charge
			$table->foreign('user_id')->references('id')->on('user'); 
			$table->datetime('time');
			$table->boolean('inout');
			$table->boolean('computers');
			$table->boolean('peripherals');
			$table->boolean('light');
			$table->boolean('aircon');
			$table->boolean('clean'); //cleanliness and orderliness
			$table->string('notes',100)->nullable();
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
		Schema::drop('log');
	}

}
