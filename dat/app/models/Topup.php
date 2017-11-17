<?php

class Topup extends \Eloquent {

	protected $table='topups';
	// Add your validation rules here
	public static $rules = [
		'amount' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];

	public function loanaccounts(){
		return $this->hasMany('Loanaccount');
	}

	//A function to handle loan top ups
	public static function recordTopup($loanaccount,$data){	
		$rate = $loanaccount->interest_rate/100;
		$time = $loanaccount->repayment_duration;
		$formula = $loanaccount->loanproduct->formula;
		$principal=$data['amount'];
		if($formula == 'SL'){
			$interest_amount = $principal * $rate * $time;
		}else if($formula == 'RB'){			    		    
   			$principal_bal = $principal;
    		$interest_amount = 0;
    		$principal_pay = $principal/$time;
    		for($i=1; $i<=$time; $i++){
        		$interest_amount = ($interest_amount + ($principal_bal * $rate));
        		$principal_bal = $principal_bal - $principal_pay;        		
    		}          
		}
		$topup=new Topup();
		$topup->loanaccount_id=$loanaccount->id;
		$topup->amount=$data['amount'];
		$topup->total_payable=$data['amount']+$interest_amount;
		$topup->save();
		//update the loan to handle the top ups
		$loan=Loanaccount::find($loanaccount->id);	
		$loan->is_top_up = true;
		$loan->top_up_amount=$loanaccount->top_up_amount + $data['amount'];
		$loan->save();	
	}

}