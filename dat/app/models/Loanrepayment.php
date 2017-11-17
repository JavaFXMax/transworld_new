<?php

class Loanrepayment extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];


	public function loanaccount(){
		return $this->belongsTo('Loanaccount');
	}

	public static function getPrincipalPaid($loanaccount){
					$paid = DB::table('loanrepayments')->where('void',0)->where('loanaccount_id', '=', $loanaccount->id)
					->sum('principal_paid');
					return $paid;
	}

	public static function getInterestPaid($loanaccount){
			$paid = DB::table('loanrepayments')->where('void',0)->where('loanaccount_id', '=', $loanaccount->id)->sum('interest_paid');
			return $paid;
	}

	public static function repayLoan($data){
					$loanaccount_id = array_get($data, 'loanaccount_id');
					$loanaccount = Loanaccount::findorfail($loanaccount_id);
			    $amount = array_get($data, 'amount');
					$category = "Cash";
					$member = array_get($data, 'member');
					$date = array_get($data, 'date');
					$chosen_date= date('d',strtotime($date));
					$chosen_month =date('m',strtotime($date));
					$chosen_year =date('Y',strtotime($date));
					$last_month_date= date('t',strtotime($date));
					$principal_due = Loanaccount::getLoanAmount($loanaccount) / $loanaccount->repayment_duration;
					$interest_due = Loantransaction::getInterestDue($loanaccount);
					$total_due = $principal_due + $interest_due;
					$paymentamount = $amount;
				 	if($paymentamount < $total_due){
										 		$payamount = $paymentamount;
													//pay interest first
										 		if($payamount >= $interest_due){
																				Loanrepayment::payInterest($loanaccount, $date, $interest_due);
																				$payamount = $payamount - $interest_due;
																				if($payamount > 0){
																					Loanrepayment::payPrincipal($loanaccount, $date, $payamount);
																				}
										 		}elseif($payamount < $interest_due){
																		Loanrepayment::payInterest($loanaccount, $date, $payamount);
									 		}
					}
					if($paymentamount >= $total_due){
										$payamount = $paymentamount;
										//pay interest first
										Loanrepayment::payInterest($loanaccount, $date, $interest_due);
										$payamount = $payamount - $interest_due;
										//pay principal with the remaining amount
										Loanrepayment::payPrincipal($loanaccount, $date, $payamount);
					}
					/*Add Arrears Since it is the end of the specific month*/
					if( $chosen_date >= $last_month_date){
							$sum_amounts = Loantransaction::where('loanaccount_id','=',$loanaccount)->where('type','=','credit')
							->where(DB::raw('MONTH(created_at)'), '=', $chosen_month)->where(DB::raw('YEAR(created_at)'), '=', $chosen_year)
							->sum('amount');
							$arrears_amount = array_get($data, 'amount_supposed_to_pay') -  $sum_amounts;
						   Loantransaction::repayLoan($loanaccount, $amount, $date, $category, $member, $arrears_amount);
					}
					/*Do not Add Arrears Since it is not yet end of the specific month*/
					if($chosen_date < $last_month_date){
						   Loantransaction::repayLoan($loanaccount, $amount, $date, $category, $member, 0);
					}
	}

	public static function vrepayLoan($loanamt,$loanaccount_id,$member,$vid){
					$loanaccount = Loanaccount::findorfail($loanaccount_id);
			  	$amount = $loanamt;
					$category = "Cash";
					$date = date('Y-m-d');
					$principal_due = Loantransaction::getPrincipalDue($loanaccount);
					$interest_due = Loantransaction::getInterestDue($loanaccount);
					$total_due = $principal_due + $interest_due;
					$paymentamount = $amount;
				 	if($paymentamount < $total_due){
				 				$payamount = $paymentamount;
										//pay interest first
									 		if($payamount >= $interest_due){
														Loanrepayment::payInterest($loanaccount, $date, $interest_due);
														$payamount = $payamount - $interest_due;
														if($payamount > 0){
															Loanrepayment::payPrincipal($loanaccount, $date, $payamount);
														}
									 		}elseif($payamount < $interest_due){
												Loanrepayment::payInterest($loanaccount, $date, $payamount);
				 		}
	}


		if($paymentamount >= $total_due){

			$payamount = $paymentamount;
			//pay interest first
			Loanrepayment::payInterest($loanaccount, $date, $interest_due);
			$payamount = $payamount - $interest_due;

			//pay principal with the remaining amount
			Loanrepayment::payPrincipal($loanaccount, $date, $payamount);
		}
		Loantransaction::vrepayLoan($loanaccount, $amount, $date, $category, $member, $vid);
	}



	public static function offsetLoan($data){

		$loanaccount_id = array_get($data, 'loanaccount_id');

		$loanaccount = Loanaccount::findorfail($loanaccount_id);

		$amount = array_get($data, 'amount');
		$date = array_get($data, 'date');


		$principal_bal = Loanaccount::getPrincipalBal($loanaccount);
		$interest_bal = Loanaccount::getInterestBal($loanaccount);



		//pay principal

 		Loanrepayment::payPrincipal($loanaccount, $date, $principal_bal);

 		//pay interest
 		Loanrepayment::payInterest($loanaccount, $date, $interest_bal);



		Loantransaction::repayLoan($loanaccount, $amount, $date);






	}




	public static function payPrincipal($loanaccount, $date, $principal_due){
				$repayment = new Loanrepayment;
				$repayment->loanaccount()->associate($loanaccount);
				$repayment->date = $date;
				$repayment->principal_paid = $principal_due;
				$repayment->save();

		$account = Loanposting::getPostingAccount($loanaccount->loanproduct, 'principal_repayment');

		$data = array(
			'credit_account' =>$account['credit'] ,
			'debit_account' =>$account['debit'] ,
			'date' => $date,
			'amount' => $principal_due,
			'initiated_by' => 'system',
			'description' => 'principal repayment'

			);


		$journal = new Journal;


		$journal->journal_loan($data);

	}


	public static function payInterest($loanaccount, $date, $interest_due){
		$repayment = new Loanrepayment;
		$repayment->loanaccount()->associate($loanaccount);
		$repayment->date = $date;
		$repayment->interest_paid = $interest_due;
		$repayment->save();



		$account = Loanposting::getPostingAccount($loanaccount->loanproduct, 'interest_repayment');

		$data = array(
			'credit_account' =>$account['credit'] ,
			'debit_account' =>$account['debit'] ,
			'date' => $date,
			'amount' => $interest_due,
			'initiated_by' => 'system',
			'description' => 'interest repayment'

			);


		$journal = new Journal;


		$journal->journal_entry($data);

	}

	public static function vpayPrincipal($loanaccount, $date, $principal_due,$vid){

		$repayment = new Loanrepayment;


		$repayment->loanaccount()->associate($loanaccount);
		$repayment->date = $date;
		$repayment->principal_paid = $principal_due;
		$repayment->save();

        $vehsav = Vehicleincome::where('id',$vid)->first();
        $vehsav->loanrepayment_principal_id = $repayment->id;
        $vehsav->update();

		$account = Loanposting::getPostingAccount($loanaccount->loanproduct, 'principal_repayment');

		$data = array(
			'pcredit_account' =>$account['credit'] ,
			'pdebit_account' =>$account['debit'] ,
			'date' => $date,
			'amount' => $principal_due,
			'initiated_by' => 'system',
			'description' => 'principal repayment',
			'vid'=>$vid

			);


		$journal = new Journal;


		$journal->journal_loan($data);

	}


	public static function vpayInterest($loanaccount, $date, $interest_due,$vid){

		$repayment = new Loanrepayment;


		$repayment->loanaccount()->associate($loanaccount);
		$repayment->date = $date;
		$repayment->interest_paid = $interest_due;
		$repayment->save();

        $vehsav = Vehicleincome::where('id',$vid)->first();
        $vehsav->loanrepayment_interest_id = $repayment->id;
        $vehsav->update();

		$account = Loanposting::getPostingAccount($loanaccount->loanproduct, 'interest_repayment');

		$data = array(
			'icredit_account' =>$account['credit'] ,
			'idebit_account' =>$account['debit'] ,
			'date' => $date,
			'amount' => $interest_due,
			'initiated_by' => 'system',
			'description' => 'interest repayment',
            'vid'=>$vid
			);


		$journal = new Journal;


		$journal->journal_loan($data);

	}

}
