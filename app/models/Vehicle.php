<?php

class Vehicle extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		'regno' => 'required',
		'make' => 'required',
	];

	public static $messages = array(
		'make.required'=>'Please insert vehicle make!',
        'regno.required'=>'Please insert vehicle registration number!',  
    );

	// Don't forget to fill this array
	protected $fillable = [];


	public function member(){

		return $this->belongsTo('Member');
	}

	public static function assignedvehicle($id){
      
        $vehicle = Vehicle::find($id);
        
		return $vehicle;
	}

}