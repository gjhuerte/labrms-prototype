<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryForeignKey extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('inventory', function(Blueprint $table)
		{
			$table->foreign('itemtype_id')->references('id')->on('itemtype');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('inventory', function(Blueprint $table)
		{
			$table->dropForeign('inventory_itemtype_id_foreign');
		});
	}

}
