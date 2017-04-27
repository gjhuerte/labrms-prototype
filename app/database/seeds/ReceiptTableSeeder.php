
<?php

class ReceiptTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
         //delete users table records
         DB::table('receipt')->delete();	

         //insert some dummy records
         DB::table('receipt')->insert(array(
             ['number'=>'17-04-124','inventory_id'=>'1'],
             ['number'=>'17-04-124','inventory_id'=>'2'],
             ['number'=>'17-04-124','inventory_id'=>'3'],
             ['number'=>'17-04-124','inventory_id'=>'4'],
             ['number'=>'17-03-59','inventory_id'=>'5'],
             ['number'=>'17-03-59','inventory_id'=>'6'],
             ['number'=>'17-03-59','inventory_id'=>'7'],
             ['number'=>'17-03-59','inventory_id'=>'8'],

          ));
	}


}

		
