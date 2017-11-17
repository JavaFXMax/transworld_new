<?php

class Contribution extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];


	public static function sumtotal($id,$from,$to){

		$total = DB::table('contributions')->where('member_id', '=', $id)->whereBetween('date', array($from, $to))->where('type', '=', 'debit')->where('is_void',false)->sum('amount');

		return $total;
	}


	public static function debittotal($id,$from,$to){

		$total = DB::table('contributions')->where('member_id', '=', $id)->whereBetween('date', array($from, $to))->where('type', '=', 'debit')->where('is_void',false)->sum('amount');

		return $total;
	}

	public static function credittotal($id,$from,$to){

		$total = DB::table('contributions')->where('member_id', '=', $id)->whereBetween('date', array($from, $to))->where('type', '=', 'credit')->where('is_void',false)->sum('amount');

		return $total;
	}

	public static function sum($id){

		$total = DB::table('contributions')->where('member_id', '=', $id)->where('type', '=', 'debit')->where('is_void',false)->sum('amount');

		return $total;
	}


	public static function add($data){

		$cont = new Contribution;
		$cont->member_id = array_get($data, 'member_id');
		$cont->date = array_get($data, 'date');
		$cont->amount = array_get($data, 'amount');
		$cont->type = array_get($data, 'type');
		$cont->reason = array_get($data, 'reasons');
		$cont->save();

		if(array_get($data, 'type') == 'debit'){


			$data = array(
			'date' => array_get($data, 'date'), 
			'debit_account' => array_get($data, 'debit_account'),
			'credit_account' => array_get($data, 'credit_account'),
			'description' => 'office contribution',
			'amount' => array_get($data, 'amount'),
			'initiated_by' => Confide::user()->username,
			'cid' => $cont->id
			);
		
		$journal = new Journal;

		$journal->journal_contentry($data);

		}
		

	}




	public static function nadd($data, $credit_account, $debit_account){

		$cont = new Contribution;
		$cont->member_id = array_get($data, 'member_id');
		$cont->date = array_get($data, 'date');
		$cont->amount = array_get($data, 'amount');
		$cont->type = array_get($data, 'type');
		$cont->save();

		/*if(array_get($data, 'type') == 'debit'){


			$data = array(
			'date' => array_get($data, 'date'), 
			'debit_account' => $debit_account,
			'credit_account' => $credit_account,
			'description' => 'office contribution',
			'amount' => array_get($data, 'amount'),
			'initiated_by' => Confide::user()->username
			);
		
		$journal = new Journal;

		$journal->journal_entry($data);

		}*/
		

	}

	public static function getContBalance($mid,$from,$to){

		$deposits = DB::table('contributions')->where('member_id', '=', $mid)->where('is_void', '=', 0)->where('type', '=', 'credit')->whereBetween('date', array($from, $to))->sum('amount');
		$withdrawals = DB::table('contributions')->where('member_id', '=', $mid)->where('is_void', '=', 0)->where('type', '=', 'debit')->whereBetween('date', array($from, $to))->sum('amount');

		$balance = $deposits - $withdrawals;

		return $balance;
	}

	public static function getContAmount($mid,$id,$from,$to){

		$amount = DB::table('contributions')->where('member_id', '=', $mid)->where('id', '=', $id)->where('is_void', '=', 0)->whereBetween('date', array($from, $to))->sum('amount');

		return $amount;
	}

}