
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
         DB::table('itemtype')->insert(array(
             ['type' => 'System Unit','description' => 'Computer set'],
             ['type' => 'Display','description' => 'Visual aids'],
             ['type' => 'AVR','description' => 'Power Regulator'],
             ['type' => 'Aircon','description' => 'Cooling appliance'],
             ['type' => 'TV','description' => 'Visual aids'],
             ['type' => 'Projector','description' => 'Visual aids'],
             ['type' => 'Extension','description' => 'Extension cord'],
             ['type' => 'Office Equipment','description' => 'electric fan'],

          ));
	}



}
