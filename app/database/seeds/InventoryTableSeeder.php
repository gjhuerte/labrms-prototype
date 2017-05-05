
<?php

class InventoryTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
         //delete users table records
         DB::table('inventory')->delete();	

         //insert some dummy records
         DB::table('inventory')->insert(array(
             ['itemtype'=>'DESKTOP COMPUTER','brand'=>'DELL','model'=>'VOSTRO 3640','details'=>'6th Generation Intel Core i55-6400 processor 6m cache, up to 3.30 Ghz, 8gb RAM DDR3 , 1TB 7200rpm SATA Hard Disk Drive, USB Keyboard, USB Optical Mouse, 500W AVR, Ethernet 10/100/1000 USB at least 4x2.0 and 2x3.0 ports, Oprical Drive DVD-Rw at least 21.5 inch LED Widescreen Monitor Graphics: NVIDIA GeForce 2GB GDDR3,Windows 10 pro 64-bit, 5-in-1 multi card reader','warranty'=>'1 year on parts and 3 years service','unit'=>'SET','quantity'=>'138','profileditems'=>'0']/*,
			 ['itemtype'=>'MONITOR','brand'=>'DELL','details'=>'21.5" LED','unit'=>'PCS','quantity'=>'138',
			 'profileditems'=>'0'],
			 ['itemtype'=>'KEYBOARD','brand'=>'DELL','details'=>'USB','unit'=>'PCS','quantity'=>'138','profileditems'=>'0'],
			 ['itemtype'=>'AVR','details'=>'500 WATT','unit'=>'PCS','quantity'=>'138','profileditems'=>'0'],
			 ['itemtype'=>'DESKTOP COMPUTER','brand'=>'DELL','model'=>'OPTIPLEX 3040 MT','details'=>'Intel Core I3-6100 3.7 GHZ , 4 GB 1600MHz Non ECC DDR3 SDRAM, 1TB 7200rpm 3.5" SATA Hard Disk Drive, 16xDVDRW Drive Dell E1916H, 18.5" Monitor Wide Screen LED, Realtek RTL8111 HSD, Lan 10/100/1000, Audio Black Dell KB216 Keyboard Black and Computer Unit Brand must belong to 2014 Magic Quadrant for Global enterprise Desktopsand Notebooks Operating system: Windows 10 pro OS 64bit, Integrated HD Graphics 530, 4 USB 3.0/2.0 PORTS, 1 HDMI, 1 Display Port,1.2, AVR 3 Outlets Output','unit'=>'SET','quantity'=>'16','profileditems'=>'0'],
			 ['itemtype'=>'MONITOR',
             'brand'=>'DELL',
             'model'=>'E1916H',
			 'details'=>'18.5" LED',
			 'unit'=>'PCS',
			 'quantity'=>'16',
			 'profileditems'=>'0'],
			 ['itemtype'=>'KEYBOARD',
             'brand'=>'DELL',
			 'model'=>'KB216',
			 'details'=>'BLACK',
			 'unit'=>'PCS',
			 'quantity'=>'16',
			 'profileditems'=>'0'],
			 ['itemtype'=>'AVR',
             'details'=>'3 Outlets output',
			 'unit'=>'PCS',
			 'quantity'=>'16',
			 'profileditems'=>'0'],*/

          ));
	}


	
 





}

		
