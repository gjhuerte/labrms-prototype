<?php

class PurposeTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		//delete purpose table records
		DB::table('purpose')->delete();

		//insert some dummy records
		// Purpose::create(array(
    //   'title'=>'',
    //   'description'=>''
		// ));

		Purpose::create(array(
      'title'=>'Oral Defense',
      'description'=>''
		));

		Purpose::create(array(
      'title'=>'General Assembly',
      'description'=>''
		));

		Purpose::create(array(
      'title'=>'Seminar',
      'description'=>''
		));

		Purpose::create(array(
      'title'=>'Tutorial',
      'description'=>''
		));

		Purpose::create(array(
      'title'=>'Make-up Classes',
      'description'=>''
		));

		Purpose::create(array(
      'title'=>'Class Presentation',
      'description'=>''
		));

		Purpose::create(array(
      'title'=>'Class Activity',
      'description'=>''
		));
	}



}
