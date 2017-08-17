<?php

class PcSoftware extends Eloquent{
	protected $table = 'pc_software';
	public $timestamps = true;
	public $fillable = ['pc_id','software_id','softwarelicense_id'];

	public static $rules = array(
		'PC ID' => 'exists:pc,id|required',
		'Software ID' => 'exists:software,id|required',
		'Software License Key' => 'exists:softwarelicense,key'
	);

	public static $withoutLicenseRules = array(
		'PC ID' => 'exists:pc,id|required',
		'Software ID' => 'exists:software,id|required'
	);

	public static $updateRules = array(
		'PC ID' => 'exists:pc,id|required',
		'Software ID' => 'exists:software,id|required',
		'Software License Key' => 'exists:softwarelicense,key'
	);

	public function software()
	{
		return $this->belongsTo('software','software_id','id');
	}

	public function pc()
	{
		return $this->belongsTo('pc','pc_id','id');
	}

	public function softwarelicense()
	{
		return $this->belongsTo('SoftwareLicense','softwarelicense_id','id');
	}

    /**
    *
    *	install software
    *	@param $id accepts pc id
    *	@param $software accepts software id
    *	@param $softwarelicense accepts software license information
    *
    */
	public static function installSoftware($id,$software,$softwarelicense)
	{

		$software = Software::find($software);

		$pcsoftware = new Pcsoftware;
		$pcsoftware->pc_id = $id;
		$pcsoftware->software_id = $software->id;

		try {

			$softwarelicense = SoftwareLicense::where('key','=',$softwarelicense)	
												->where('software_id','=',$software->id)
												->first();

			SoftwareLicense::install($softwarelicense->id);
			$pcsoftware->softwarelicense_id = $softwarelicense->id;
		} catch (Exception $e) {}

		$pcsoftware->save();

		/*
		*
		*	create a maintenance ticket
		*
		*/
		$softwarename = $pcsoftware->software->softwarename;
		$details = "$softwarename has been installed";
		$staffassigned = Auth::user()->id;
		$author = Auth::user()->firstname . " " . Auth::user()->middlename . " " . Auth::user()->lastname;
		Ticket::generatePcTicket(
			$id,
			'Maintenance',
			'Installed Software',
			$details,
			$author,
			$staffassigned,
			null,
			'Closed'
		);
	}

    /**
    *
    *	update installed software information
    *	@param $id accepts pc id
    *	@param $software accepts software id
    *
    */
	public static function updateInstalledSoftware($id,$software)
	{
		$pcsoftware = PcSoftware::where('pc_id',$id)
								->where('software_id',$software)
								->first();

		if($pcsoftware->softwarelicense_id != null)
		{
			try
			{
				Softwarelicense::uninstall($pcsoftware->softwarelicense_id);
			} catch (Exception $e) {}	
		}	

		Pc::find($id)->software()->detach($software);

		$softwarelicense = $this->sanitizeString(Input::get('softwarelicense'));

		$software = Software::find($software);
		$pcsoftware = new Pcsoftware;
		$pcsoftware->pc_id = $id;
		$pcsoftware->software_id = $software->id;

		try 
		{

			$softwarelicense = SoftwareLicense::where('key','=',$softwarelicense)	
												->where('software_id','=',$software->id)
												->first();

			$id = $softwarelicense->id;
			SoftwareLicense::install($id);
			$pcsoftware->softwarelicense_id = $id;
		} catch (Exception $e) 
		{
			$pcsoftware->softwarelicense_id = null;
		}

		$pcsoftware->save();
	}

    /**
    *
    *	uninstall software
    *	@param $id accepts pc id
    *	@param $software accepts software id
    *
    */
    public static function uninstallSoftware($id,$software)
    {

		$pcsoftware = PcSoftware::where('pc_id',$id)
								->where('software_id',$software)
								->first();

		try
		{
			Softwarelicense::uninstall($pcsoftware->softwarelicense_id);
		} catch (Exception $e) {}

		Pc::find($id)->software()->detach($software);

		/*
		*
		*	create a transfer ticket
		*
		*/
		$softwarename = $pcsoftware->software->softwarename;
		$details = "$softwarename has been removed from workstation";
		$staffassigned = Auth::user()->id;
		$author = Auth::user()->firstname . " " . Auth::user()->middlename . " " . Auth::user()->lastname;
		Ticket::generatePcTicket(
			$id,
			'Maintenance',
			'Uninstalled Software',
			$details,
			$author,
			$staffassigned,
			null,
			'Closed'
		);
    }
}
