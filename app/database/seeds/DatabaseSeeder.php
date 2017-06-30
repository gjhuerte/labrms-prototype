<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('UserTableSeeder');
		$this->call('RoomTableSeeder');
		$this->call('ItemtypeTableSeeder');
		$this->call('TickettypeTableSeeder');
		$this->call('PurposeTableSeeder');

	}

}
