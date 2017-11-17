<?php

class Assignvehicle extends \Eloquent {

	// Add your validation rules here
    
    public static $rules = [
		'vehicle_id' => 'required',
		'member_id' => 'required',
	];

	public static $messages = array(
		'vehicle_id.required'=>'Please select vehicle!',
        'member_id.required'=>'Please select member!',  
    );	

	// Don't forget to fill this array
	protected $fillable = [];


	public function member(){

		return $this->belongsTo('Member');
	}

}