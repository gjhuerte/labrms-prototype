
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
             ['name' => 'S501','description' => 'Web Development'],
             ['name' => 'S502','description' => 'Networking'],
             ['name' => 'S503','description' => 'Networking'],
             ['name' => 'S504','description' => 'Hardware,Networking'],
             ['name' => 'Consultation Room','description' => 'Consultation,Meeting'],
             ['name' => 'Faculty Room','description' => 'Faculty Area'],
             ['name' => 'Server','description' => 'Center of Service'],
             ['name' => 'S508','description' => 'Programming,Web Development'],
             ['name' => 'S510','description' => 'Database,Web Development,Multimedia'],
             ['name' => 'S511','description' => 'Multimedia'],

          ));
	}



}
