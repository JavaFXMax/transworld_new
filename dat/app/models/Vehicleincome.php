<?php

class Vehicleincome extends \Eloquent {

	// Add your validation rules here
    
    public static $rules = [
		'vehicle_id' => 'required',
		'date' => 'required',
		'asset_id' => 'required',
		'ainc_id' => 'required',
	
	];

	public static $messages = array(
		'vehicle_id.required'=>'Please select vehicle!',
		'date.required'=>'Please select date!',     
        'asset_id.required'=>'Please select account!',  
        'ainc_id.required'=>'Please select account!',  
    );	

	// Don't forget to fill this array
	protected $fillable = [];


	public function member(){

		return $this->belongsTo('Member');
	}

}