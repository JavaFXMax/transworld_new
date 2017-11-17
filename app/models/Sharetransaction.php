<?php

class Sharetransaction extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];


	public function shareaccount(){

		return $this->belongsTo('Shareaccount');
	}

	public static function getAmount($share,$from,$to){

		$amount = DB::table('sharetransactions')->where('shareaccount_id', '=', $share->id)->whereBetween('date', array($from, $to))->sum('amount');

		return $amount;
	}

	public static function getBalance($share,$from,$to){

		$deposits = DB::table('sharetransactions')->where('shareaccount_id', '=', $share->id)->where('type', '=', 'credit')->whereBetween('date', array($from, $to))->sum('amount');
		$withdrawals = DB::table('sharetransactions')->where('shareaccount_id', '=', $share->id)->where('type', '=', 'debit')->whereBetween('date', array($from, $to))->sum('amount');

		$balance = $deposits - $withdrawals;

		return $balance;
	}
}