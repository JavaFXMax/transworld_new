<?php

class Charge extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];


	public function loanproducts(){

		return $this->belongsToMany('Loanproduct');
	}


	public function savingproducts(){

		return $this->belongsToMany('Savingproduct');
	}


	public static function applyFee($fee_id){

		$charge = Charge::find($fee_id);

		$data = array(
			'date' => date('Y-m-d'), 
			'debit_account' => $charge->debit_account,
			'credit_account' => $charge->credit_account,
			'description' => 'vehicle registration fee',
			'amount' => $charge->amount,
			'initiated_by' => Confide::user()->username
			);
		
		$journal = new Journal;

		$journal->journal_entry($data);
	}

	

}