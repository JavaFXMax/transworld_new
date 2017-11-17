<?php

class Memberfee extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		 'member_registration_fee' => 'required',
		 'eq_id' => 'required',
	];

	// Don't forget to fill this array
	protected $fillable = [];

	public function account(){

		return $this->belongsTo('Account');
	}

}