
<?php

class RoomTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
         //delete users table records
         DB::table('room')->delete();	

         //insert some dummy records
         DB::table('room')->insert(array(
             ['name' => 'S501','description' => '0'],
             ['name' => 'S502','description' => '0'],
             ['name' => 'S503','description' => '0'],
             ['name' => 'S504','description' => '0'],
             ['name' => 'Consultation Room','description' => '0'],
             ['name' => 'Faculty Room','description' => '0'],
             ['name' => 'Server','description' => '0'],
             ['name' => 'S508','description' => '0'],
             ['name' => 'S510','description' => '0'],
             ['name' => 'S511','description' => '0'],

          ));
	}



}
