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
			 'firstname' => 'Administrator',
			 'middlename' => '',
			 'lastname' => 'Only',
			 'contactnumber' => '09123456789',
			 'email' => 'admin@yahoo.com',
			 'type' => 'faculty',
			 'status' => '1'
		));

		//insert some dummy records
		User::create(array(
		   'username' => 'labassistant',
		   'password' => Hash::make('12345678'),
		   'accesslevel' =>'1',
			 'firstname' => 'Laboratory',
			 'middlename' => '',
			 'lastname' => 'Assistant',
			 'contactnumber' => '09123456789',
			 'email' => 'labassistant@yahoo.com',
			 'type' => 'faculty',
			 'status' => '1'
		));

		//insert some dummy records
		User::create(array(
		   'username' => 'labstaff',
		   'password' => Hash::make('12345678'),
		   'accesslevel' =>'2',
			 'firstname' => 'Laboratory',
			 'middlename' => '',
			 'lastname' => 'Staff',
			 'contactnumber' => '09123456789',
			 'email' => 'labstaff@yahoo.com',
			 'type' => 'faculty',
			 'status' => '1'
		));

		//insert some dummy records
		User::create(array(
		   'username' => 'faculty',
		   'password' => Hash::make('12345678'),
		   'accesslevel' =>'3',
			 'firstname' => 'Faculty',
			 'middlename' => '',
			 'lastname' => 'Office',
			 'contactnumber' => '09123456789',
			 'email' => 'faculty@yahoo.com',
			 'type' => 'faculty',
			 'status' => '1'
		));

		//insert some dummy records
		User::create(array(
		   'username' => 'student',
		   'password' => Hash::make('12345678'),
		   'accesslevel' =>'4',
			 'firstname' => 'John',
			 'middlename' => '',
			 'lastname' => 'Doe',
			 'contactnumber' => '09123456789',
			 'email' => 'johndoe@yahoo.com',
			 'type' => 'johndoe',
			 'status' => '1'
		));
	}



}
