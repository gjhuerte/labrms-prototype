
<?php

class TickettypeTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
   	//delete users table records
   	DB::table('tickettype')->delete();

    Tickettype::create(['type'=>'Action Taken']);
    Tickettype::create(['type'=>'Transfer']);
    Tickettype::create(['type'=>'Maintenance']);
    Tickettype::create(['type'=>'Lent']);
    Tickettype::create(['type'=>'Incident']);
	}

}
