
<?php

class UserTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
         //delete users table records
         DB::table('user')->delete();	

         //insert some dummy records
         DB::table('user')->insert(array(
             ['username' => 'admin','password' => Hash::make('123456'),'accesslevel' =>'0','firstname' => 'fred','middlename' => 'grejalde','lastname' => 'yu','contactnumber' => '091234567','email' => 'fred@yahoo.com','type' => 'faculty','status' => '1'],

          ));
	}



}

		
