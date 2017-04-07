<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('username',50)->unique();
			$table->string('password',254);
			$table->integer('accesslevel');
			$table->string('firstname',100);
			$table->string('middlename',50);
			$table->string('lastname',50);
			$table->string('contactnumber',50);
			$table->string('email',100);
			$table->string('type',50);
			$table->boolean('status');
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
		Schema::drop('user');
	}

}
