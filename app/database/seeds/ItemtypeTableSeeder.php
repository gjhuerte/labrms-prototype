<?php
class ItemtypeTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		//delete users table records
		DB::table('itemtype')->delete();
		//insert some dummy records
		Itemtype::create(array(
		   'name' => 'System Unit',
		   'description' => 'Computer set',
		   'category' => 'equipment'
		));
		Itemtype::create(array(
		  'name' => 'Display',
		  'description' => 'Visual aids',
		  'category' => 'equipment'
		));
		Itemtype::create(array(
		 'name' => 'AVR',
		 'description' => 'Power Regulator',
		 'category' => 'equipment'
		));
		Itemtype::create(array(
		 'name' => 'Aircon',
		 'description' => 'Cooling appliance',
		 'category' => 'equipment'
		));
		Itemtype::create(array(
		 'name' => 'TV',
		 'description' => 'Visual aids',
		 'category' => 'equipment'
		));
		Itemtype::create(array(
		  'name' => 'Projector',
		  'description' => 'Visual aids',
		  'category' => 'equipment'
		));
		Itemtype::create(array(
		  'name' => 'Extension',
		  'description' => 'Extension cord or any other power source',
		  'category' => 'supply'
		));
		Itemtype::create(array(
		  'name' => 'Keyboard',
		  'description' => 'Computer parts used as an input',
		  'category' => 'equipment'
		));
		Itemtype::create(array(
		  'name' => 'Mouse',
		  'description' => '',
		  'category' => 'supply'
		));
	}
}
