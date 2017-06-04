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
		User::create(array(
		   'username' => 'admin',
		   'password' => Hash::make('12345678'),
		   'accesslevel' =>'0',
			 'firstname' => 'John',
			 'middlename' => '',
			 'lastname' => 'Doe',
			 'contactnumber' => '09123456789',
			 'email' => 'fred@yahoo.com',
			 'type' => 'faculty',
			 'status' => '1'
		));
	}



}
