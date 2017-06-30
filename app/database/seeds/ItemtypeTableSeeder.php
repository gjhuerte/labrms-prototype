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
		   'name' => 'System Unit','description' => 'Computer set'
		));
		Itemtype::create(array(
		  'name' => 'Display','description' => 'Visual aids'
		));
		Itemtype::create(array(
		 'name' => 'AVR','description' => 'Power Regulator'
		));
		Itemtype::create(array(
		 'name' => 'Aircon','description' => 'Cooling appliance'
		));
		Itemtype::create(array(
		 'name' => 'TV','description' => 'Visual aids'
		));
		Itemtype::create(array(
		  'name' => 'Projector','description' => 'Visual aids'
		));
		Itemtype::create(array(
		  'name' => 'Extension','description' => 'Extension cord or any other power source'
		));
		Itemtype::create(array(
		  'name' => 'Office Equipment','description' => 'electric fan'
		));
		Itemtype::create(array(
		  'name' => 'Keyboard','description' => 'Computer parts used as an input'
		));
	}
}
