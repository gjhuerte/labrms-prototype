 <?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Carbon\Carbon;
class Reservation extends Eloquent{
		use SoftDeletingTrait;
	//Database driver
		/*
			1 - Eloquent (MVC Driven)
			2 - DB (Directly query to SQL database, no model required)
		*/

		//The table in the database used by the model.
		protected $table = 'reservation';
		protected $dates = ['deleted_at'];
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
		//Validation rules!
		public static $rules = array(
			'item name' => 'required|exists:Itemprofile,id',
			'location' => 'required|between:4,100',
			'date of use' => 'required|date',
			'time started' => 'required|date',
			'time end' => 'required|date',
			'purpose' => 'required',
			'faculty-in-charge' => 'required|between:5,50|string'
		);

		public static $updateRules = array(
			'item name' => 'required|exists:Itemprofile,id',
			'location' => 'required|between:4,100',
			'date of use' => 'required|date',
			'time started' => 'required|date',
			'time end' => 'required|date',
			'purpose' => 'required',
			'faculty-in-charge' => 'required|between:5,50|string'
		);

		public function itemprofile()
		{
			return $this->belongsTo('Itemprofile','item_id','id');
		}

		public function user()
		{
			return $this->belongsTo('User','user_id','id');
		}

		public function inventory()
		{
			return $this->hasManyThrough('Inventory','Itemprofile','inventory_id','id');
		}

		public function hasReserved($property_number,$start,$end,$date)
		{			
			foreach(Reservation::all() as $reservation)
			{
				if(count($reservation->itemprofile) > 0){
					if($reservation->itemprofile->id == $property_number){
					 	// check if reservation is disapproved 
						if($reservation->approval != '2'){
							$dateofuse = Carbon::parse($reservation->dateofuse);
							if(Carbon::parse($date)->isSameDay($dateofuse))
							{
								$timein = Carbon::parse($reservation->timein);
								$timeout = Carbon::parse($reservation->timeout);

								//if start time is in between time in and out of a reservation
								if( Carbon::parse($start)->between( $timein , $timeout ) )
								{
									//if start time not equals timeout
									if(Carbon::parse($start) != Carbon::parse($timeout)){
										//error
										return $reservation;
									}	
								}

								//if end time is in between time in and out of reservation
								if( Carbon::parse($end)->between( $timein , $timeout ) )
								{
									//if end time not equals the start time
									if(Carbon::parse($start) != Carbon::parse($timein)){
										//error
										return $reservation;
									}	
								}
							}
						}
					}	
				}	
			} 
			// no reserved item yet
			return false;
		}
}