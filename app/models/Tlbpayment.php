<?php

class Tlbpayment extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		 'amount' => 'required',
		 'eq_id' => 'required',
		 'date' => 'required',
	];

	// Don't forget to fill this array
	protected $fillable = [];

	public function account(){

		return $this->belongsTo('Account');
	}

	public function vehicle(){

		return $this->belongsTo('Vehicle');
	}

}