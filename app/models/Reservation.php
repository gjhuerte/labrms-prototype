 <?php

use Carbon\Carbon;
class Reservation extends Eloquent{
	//Database driver
		/*
			1 - Eloquent (MVC Driven)
			2 - DB (Directly query to SQL database, no model required)
		*/

		//The table in the database used by the model.
		protected $table = 'reservation';
		public $timestamps = true;
		public $fillable = [
			'item_id',
			'purpose_id',
			'user_id',
			'faculty-in-charge',
			'location',
			'dateofuse',
			'timein',
			'timeout',
			'approval'
		];
		protected $primaryKey = 'id';
		//Validation rules!
		public static $rules = array(
			'Item name' => 'required|exists:Itemprofile,id',
			'Location' => 'required|between:4,100',
			'Date of use' => 'required|date',
			'Time started' => 'required|date',
			'Time end' => 'required|date',
			'Purpose' => 'required',
			'Faculty-in-charge' => 'required|between:5,50|alpha'
		);

		public static $updateRules = array(
			'Item name' => 'required|exists:Itemprofile,id',
			'Location' => 'required|between:4,100',
			'Date of use' => 'required|date',
			'Time started' => 'required|date',
			'Time end' => 'required|date',
			'Purpose' => 'required',
			'Faculty-in-charge' => 'required|between:5,50|alpha'
		);


		public function hasReserved($start,$end,$date)
		{	
			$reservations = Reservation::all();
			foreach($reservations as $reservation)
			{
				$dateofuse = Carbon::parse($reservation->dateofuse);
				if(Carbon::parse($date)->isSameDay($dateofuse))
				{
					$timein = Carbon::parse($reservation->timein);
					$timeout = Carbon::parse($reservation->timeout);

					if( Carbon::parse($start)->between( $timein , $timeout ) )
					{
						return $reservation;
					}

					if( Carbon::parse($end)->between( $timein , $timeout ) )
					{
						return $reservation;
					}
				}
			}

			return false;
		}
}