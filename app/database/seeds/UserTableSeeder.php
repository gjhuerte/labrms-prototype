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
         
		User::create([
			'lastname' => 'Doe',
			'firstname' => 'John',
			'middlename' => 'Juan',
			'username' => 'admin',
			'contactnumber' => '0942481398',
			'email' => 'johndoe@gmail.com',
			'password' => Hash::make('123456'),
			'accesslevel' => '0',
			'type' => 'admin',
			'status' => '1'
		]);

	}

}