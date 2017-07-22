
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
   	Room::create(array(
       'name' => 'S501','description' => 'Web Development'
    ));
   	Room::create(array(
       'name' => 'S502','description' => 'Networking'
    ));
   	Room::create(array(
       'name' => 'S503','description' => 'Networking'
    ));
   	Room::create(array(
       'name' => 'S504','description' => 'Hardware,Networking'
    ));
   	Room::create(array(
       'name' => 'Consultation Room','description' => 'Consultation,Meeting'
    ));
   	Room::create(array(
       'name' => 'Faculty Room','description' => 'Faculty Area'
    ));
   	Room::create(array(
       'name' => 'Server','description' => 'Center of Service'
    ));
   	Room::create(array(
       'name' => 'S508','description' => 'Programming,Web Development'
    ));
   	Room::create(array(
       'name' => 'S510','description' => 'Database,Web Development,Multimedia'
    ));
   	Room::create(array(
       'name' => 'S511','description' => 'Multimedia'
    ));
	}



}
