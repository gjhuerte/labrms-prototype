 <?php
 use Illuminate\Database\Eloquent\SoftDeletingTrait;
class Ticket extends Eloquent{
		use SoftDeletingTrait;
	//Database driver
		/*
			1 - Eloquent (MVC Driven)
			2 - DB (Directly query to SQL database, no model required)
		*/

		//The table in the database used by the model.
		protected $table = 'ticket';
		protected $dates = ['deleted_at'];
		public $timestamps = true;
		public $fillable = ['title','type','clientname','description'];
		//Validation rules!
		public static $rules = array(
			'Title' => 'required|min:5|max:100|string',
			'Type' => 'required|min:5|max:50|string',
			'Details' => 'required|between:5,450|string'
		);

		public function itemprofile()
		{
			return $this->belongsTo('Itemprofile','item_id','id');
		}

		public function inventory()
		{
			return $this->hasManyThrough('Inventory','Itemprofile','inventory_id','id');
		}

		public function actiontaken()
		{
			return $this->hasMany('ActionTaken','ticket_id','id');
		}

		public function user()
		{
			return $this->belongsTo('User','clientname','username');
		}

		public function generateCondemnTicket($property_number,$itemprofile)
		{
			//create a ticket
			$ticket = Ticket::create([
				'title' => 'Condemn items',
				'description' => "Item with property number ".$property_number." sent to property office for disposal",
				'type' => 'condemn',
				'clientname' => Auth::user()->username
			]); 

			$ticket = Ticket::find($ticket->id);
			$ticket->itemprofile()->associate($itemprofile);
			//transact
			$ticket->save();
		}

		public function generateIncidentTicket($title,$description,$clientname,$property_number)
		{
			$itemprofile = Itemprofile::find($property_number);
			if(empty($itemprofile)) return false;

			$ticket = Ticket::create([
				'title' => $title,
				'description' => $description,
				'type' => 'incident',
				'clientname' => $clientname
			]);

			$ticket = Ticket::find($ticket->id);
			$ticket->itemprofile()->associate($itemprofile);
			$ticket->save();
			return true;
		}

		public function generateComplaintTicket($title,$description,$clientname,$property_number)
		{
			$itemprofile = Itemprofile::find($property_number);
			if(empty($itemprofile)) return false;

			$ticket = Ticket::create([
				'title' => $title,
				'description' => $description,
				'type' => 'complaint',
				'clientname' => $clientname
			]);

			$ticket = Ticket::find($ticket->id);
			$ticket->itemprofile()->associate($itemprofile);
			$ticket->save();
			return true;
		}

		public function generateMaintenanceTicket($title,$description,$clientname,$property_number)
		{
			$itemprofile = Itemprofile::find($property_number);
			if(empty($itemprofile)) return false;

			$ticket = Ticket::create([
				'title' => $title,
				'description' => $description,
				'type' => 'maintenance',
				'clientname' => $clientname
			]);

			$ticket = Ticket::find($ticket->id);
			$ticket->itemprofile()->associate($itemprofile);
			$ticket->save();
			return true;
		}

		public function generateOthersTicket($title,$description)
		{

			$ticket = Ticket::create([
				'title' => $title,
				'description' => $description,
				'type' => 'maintenance',
				'clientname' => Auth::user()->id
			]);

		}

		public function generateReceiveTicket($description,$item_id)
		{
			//create a ticket
			$ticket = Ticket::create([
				'title' => 'Received items',
				'description' => $description,
				'type' => 'receive',
				'clientname' => Auth::user()->username
			]); 

			$ticket = Ticket::find($ticket->id);
			$itemprofile = Itemprofile::find($item_id);
			$ticket->itemprofile()->associate($itemprofile);
			$ticket->save();
		}
}