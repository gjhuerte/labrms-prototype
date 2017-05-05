
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
             ['name' => 'S501','description'=>'Database'],
             ['name' => 'S502','description'=>'Database'],
             ['name' => 'S503','description'=>'Networking'],
             ['name' => 'S504','description'=>'Networking/Hardware'],
             ['name' => 'Consultation Room','description'=>'Consultation/Defense'],
             ['name' => 'Faculty Room','description'=>'Faculty'],
             ['name' => 'Server','description'=>'Server'],
             ['name' => 'S508','description'=>'Web Development'],
             ['name' => 'S510','description'=>'Database'],
             ['name' => 'S511','description'=>'Multimedia'],

          ));
	}



}
