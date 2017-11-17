<?php

class Vehicleexpense extends \Eloquent {

	// Add your validation rules here
    
    public static $rules = [
		'vehicle_id' => 'required',
		'date' => 'required',
		'amount' => 'required',
		'asset_id' => 'required',
		'aexp_id' => 'required',
	
	];

	public static $messages = array(
		'vehicle_id.required'=>'Please select vehicle!',
		'date.required'=>'Please select date!',   
        'amount.required'=>'Please insert amount!',     
        'asset_id.required'=>'Please select account!',  
        'aexp_id.required'=>'Please select account!',  
    );	

	// Don't forget to fill this array
	protected $fillable = [];


	public function member(){

		return $this->belongsTo('Member');
	}

}