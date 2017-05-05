<?php

class SoftwareTypeSeeder extends Seeder{
	
	public function run()
	{
         //delete users table records
         DB::table('softwaretype')->delete();	

         //insert some dummy records
         DB::table('softwaretype')->insert(array(
             ['type' => 'Operating system','description' => 'no description yet'],
             ['type' => 'Compiler or Interpreter','description' => 'Computer language compilers and interpreters'],
             ['type' => 'Programming language translators','description' => 'no description yet'],
             ['type' => 'Word processing software','description' => 'word editor'],
             ['type' => 'Spreadsheet software','description' => 'no description yet'],
             ['type' => 'Communication software','description' => 'no description yet'],
             ['type' => 'Database software','description' => 'no description yet'],
             ['type' => 'Education software','description' => 'no description yet'],
             ['type' => 'Entertainment software','description' => 'no description yet'],
             ['type' => 'Anti-virus','description' => 'no description yet'],
             ['type' => 'Registry cleaners','description' => 'no description yet'],
             ['type' => 'Disk defragmenters','description' => 'no description yet'],
             ['type' => 'Data backup utility','description' => 'no description yet'],
             ['type' => 'Multimedia','description' => 'editing and enhancing graphics'],

          ));
	}
}