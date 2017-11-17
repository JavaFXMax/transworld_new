<?php

class Journal extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];



	public function branch(){

		return $this->belongsTo('Branch');
	}


	public function account(){

		return $this->belongsTo('Account');
	}




	/**
	* function fo journal entries
	*/

	public  function journal_entry($data){


		$trans_no = $this->getTransactionNumber();


		// function for crediting

		$this->creditAccount($data, $trans_no);

		// function for crediting

		$this->debitAccount($data, $trans_no);

		
	}

	public  function journal_contentry($data){


		$trans_no = $this->getTransactionNumber();


		// function for crediting

		$this->creditContAccount($data, $trans_no);

		// function for crediting

		$this->debitContAccount($data, $trans_no);

		
	}

	public  function journal_loan($data){


		$trans_no = $this->getTransactionNumber();


		// function for crediting

		$this->creditLoanAccount($data, $trans_no);

		// function for crediting

		$this->debitLoanAccount($data, $trans_no);

		
	}

	public  function journal_equity($data){


		$trans_no = $this->getTransactionNumber();


		// function for crediting

		$this->creditEquityAccount($data, $trans_no);

		// function for crediting

		$this->debitEquityAccount($data, $trans_no);

		
	}

	public  function journal_updateequity($data){

		// function for crediting

		$trans_no = $this->getTransactionNumber();

		$this->updateCreditEquityAccount($data, $trans_no);

		// function for crediting

		$this->updateDebitEquityAccount($data, $trans_no);

		
	}


    public  function journal_update($data){

		// function for crediting

		$trans_no = $this->getTransactionNumber();

		$this->updateCreditAccount($data, $trans_no);

		// function for crediting

		$this->updateDebitAccount($data, $trans_no);

		
	}



	public function getTransactionNumber(){

		$date = date('Y-m-d H:m:s');

		$trans_no  = strtotime($date);

		return $trans_no;
	}




	public function creditAccount($data, $trans_no){

        if(isset($data['equity_credit_account'])){
        $journal = new Journal;
       
        $account = Account::findOrFail($data['equity_credit_account']);

		$journal->account()->associate($account);

		$journal->date = $data['date'];
		$journal->trans_no = $trans_no;
		$journal->initiated_by = $data['initiated_by'];
		$journal->amount = $data['offamt'];
		$journal->type = 'credit';
		$journal->description = $data['description'];
		$journal->save();

		$vehicle = Vehicleincome::where('id',$data['incid'])->first();
        $vehicle->equity_credit_journal_id = $journal->id;
        $vehicle->update();

        }

        
         
        if(isset($data['saving_credit_account']) && isset($data['vid']) && $data['description'] == 'Savings/Commissions from vehicle income'){
        $journal = new Journal;
       
        $account = Account::findOrFail($data['saving_credit_account']);

		$journal->account()->associate($account);

		$journal->date = $data['date'];
		$journal->trans_no = $trans_no;
		$journal->initiated_by = $data['initiated_by'];
		$journal->amount = $data['amount'];
		$journal->type = 'credit';
		$journal->description = $data['description'];
		$journal->save();

		$vehicle = Vehicleincome::where('id',$data['vid'])->first();
        $vehicle->savings_credit_journal_id = $journal->id;
        $vehicle->update();

        }else{
        
        $journal = new Journal;
		$account = Account::findOrFail($data['credit_account']);


	
		$journal->account()->associate($account);

		$journal->date = $data['date'];
		$journal->trans_no = $trans_no;
		$journal->initiated_by = $data['initiated_by'];
		$journal->amount = $data['amount'];
		$journal->type = 'credit';
		$journal->description = $data['description'];
		$journal->save();
        
        if(isset($data['expid']) && $data['description'] == 'Vehicles Expenses'){
          $vehicle = Vehicleexpense::where('id',$data['expid'])->first();
          $vehicle->asset_journal_id = $journal->id;
          $vehicle->update();
        }if(isset($data['incid']) && $data['description'] == 'Vehicles Incomes'){
          $vehicle = Vehicleincome::where('id',$data['incid'])->first();
          $vehicle->income_journal_id = $journal->id;
          $vehicle->update();

        }
    }
		
	}

	public function creditContAccount($data, $trans_no){

        $journal = new Journal;
       
        $account = Account::findOrFail($data['credit_account']);

		$journal->account()->associate($account);

		$journal->date = $data['date'];
		$journal->trans_no = $trans_no;
		$journal->initiated_by = $data['initiated_by'];
		$journal->amount = $data['amount'];
		$journal->type = 'credit';
		$journal->description = $data['description'];
		$journal->save();

		$vehicle = Vehicleincome::where('id',$data['cid'])->first();
        $vehicle->equity_credit_journal_id = $journal->id;
        $vehicle->update();
		
	}

	public function creditLoanAccount($data, $trans_no){

  

        if(isset($data['pcredit_account'])){
        $journal = new Journal;
       
        $account = Account::findOrFail($data['pcredit_account']);

		$journal->account()->associate($account);

		$journal->date = $data['date'];
		$journal->trans_no = $trans_no;
		$journal->initiated_by = $data['initiated_by'];
		$journal->amount = $data['amount'];
		$journal->type = 'credit';
		$journal->description = "Principal repayment";
		$journal->save();

		$vehicle = Vehicleincome::where('id',$data['vid'])->first();
        $vehicle->principal_credit_journal_id = $journal->id;
        $vehicle->update();

        }

        if(isset($data['icredit_account'])){
        $journal = new Journal;
       
        $account = Account::findOrFail($data['icredit_account']);

		$journal->account()->associate($account);

		$journal->date = $data['date'];
		$journal->trans_no = $trans_no;
		$journal->initiated_by = $data['initiated_by'];
		$journal->amount = $data['amount'];
		$journal->type = 'credit';
		$journal->description = "interest repayment";
		$journal->save();

		$vehicle = Vehicleincome::where('id',$data['vid'])->first();
        $vehicle->interest_credit_journal_id = $journal->id;
        $vehicle->update();

        }

		
	}

	
	public function creditEquityAccount($data, $trans_no){

     if(isset($data['equity_member_credit_account'])){
        $journal = new Journal;
       
        $account = Account::findOrFail($data['equity_member_credit_account']);

		$journal->account()->associate($account);

		$journal->date = $data['date'];
		$journal->trans_no = $trans_no;
		$journal->initiated_by = $data['initiated_by'];
		$journal->amount = $data['amount'];
		$journal->type = 'credit';
		$journal->description = $data['description'];
		$journal->save();

		if(isset($data['mid'])){
        $membersfee = Memberfee::where('id',$data['mid'])->first();
        $membersfee->equity_credit_journal_id = $journal->id;
        $membersfee->update();
		}
        
        if(isset($data['tid'])){
		$tlb = Tlbpayment::where('id',$data['tid'])->first();
        $tlb->equity_credit_journal_id = $journal->id;
        $tlb->update();
         }
        }

		
	}



	public function debitAccount($data,$trans_no){

		if(isset($data['equity_debit_account'])){
        $journal = new Journal;
       
        $account = Account::findOrFail($data['equity_debit_account']);

		$journal->account()->associate($account);

		$journal->date = $data['date'];
		$journal->trans_no = $trans_no;
		$journal->initiated_by = $data['initiated_by'];
		$journal->amount = $data['offamt'];
		$journal->type = 'debit';
		$journal->description = $data['description'];
		$journal->save();

		$vehicle = Vehicleincome::where('id',$data['incid'])->first();
        $vehicle->equity_debit_journal_id = $journal->id;
        $vehicle->update();

        }

        

        
        if(isset($data['saving_debit_account']) && isset($data['vid']) && $data['description'] == 'Savings/Commissions from vehicle income'){
        $journal = new Journal;
       
        $account = Account::findOrFail($data['saving_debit_account']);

		$journal->account()->associate($account);

		$journal->date = $data['date'];
		$journal->trans_no = $trans_no;
		$journal->initiated_by = $data['initiated_by'];
		$journal->amount = $data['amount'];
		$journal->type = 'debit';
		$journal->description = $data['description'];
		$journal->save();

		  $vehicle = Vehicleincome::where('id',$data['vid'])->first();
          $vehicle->savings_debit_journal_id = $journal->id;
          $vehicle->update();


        }else{

         $journal = new Journal;
		$account = Account::findOrFail($data['debit_account']);


	
		$journal->account()->associate($account);

		$journal->date = $data['date'];
		$journal->trans_no = $trans_no;
		$journal->initiated_by = $data['initiated_by'];
		$journal->amount = $data['amount'];
		$journal->type = 'debit';
		$journal->description = $data['description'];
		$journal->save();

		if(isset($data['expid']) && $data['description'] == 'Vehicles Expenses'){
          $vehicle = Vehicleexpense::where('id',$data['expid'])->first();
          $vehicle->expense_journal_id = $journal->id;
          $vehicle->update();
        }else if(isset($data['incid']) && $data['description'] == 'Vehicles Incomes'){
          $vehicle = Vehicleincome::where('id',$data['incid'])->first();
          $vehicle->asset_journal_id = $journal->id;
          $vehicle->update();

        }
    }
	}


    public function debitContAccount($data,$trans_no){

        $journal = new Journal;
       
        $account = Account::findOrFail($data['debit_account']);

		$journal->account()->associate($account);

		$journal->date = $data['date'];
		$journal->trans_no = $trans_no;
		$journal->initiated_by = $data['initiated_by'];
		$journal->amount = $data['amount'];
		$journal->type = 'debit';
		$journal->description = $data['description'];
		$journal->save();

		$contribution = Contribution::where('id',$data['cid'])->first();
        $contribution->debit_journal_id = $journal->id;
        $contribution->update();

        
	}


    public function debitLoanAccount($data,$trans_no){

        if(isset($data['pdebit_account'])){
        $journal = new Journal;
       
        $account = Account::findOrFail($data['pdebit_account']);

		$journal->account()->associate($account);

		$journal->date = $data['date'];
		$journal->trans_no = $trans_no;
		$journal->initiated_by = $data['initiated_by'];
		$journal->amount = $data['amount'];
		$journal->type = 'debit';
		$journal->description = "Principal repayment";
		$journal->save();

		$vehicle = Vehicleincome::where('id',$data['vid'])->first();
        $vehicle->principal_debit_journal_id = $journal->id;
        $vehicle->update();

        }

        if(isset($data['idebit_account'])){
        $journal = new Journal;
       
        $account = Account::findOrFail($data['idebit_account']);

		$journal->account()->associate($account);

		$journal->date = $data['date'];
		$journal->trans_no = $trans_no;
		$journal->initiated_by = $data['initiated_by'];
		$journal->amount = $data['amount'];
		$journal->type = 'debit';
		$journal->description = "interest repayment";
		$journal->save();

		$vehicle = Vehicleincome::where('id',$data['vid'])->first();
        $vehicle->interest_debit_journal_id = $journal->id;
        $vehicle->update();

        }

	}

	public function debitEquityAccount($data,$trans_no){

        if(isset($data['equity_member_debit_account'])){
        $journal = new Journal;
       
        $account = Account::findOrFail($data['equity_member_debit_account']);

		$journal->account()->associate($account);

		$journal->date = $data['date'];
		$journal->trans_no = $trans_no;
		$journal->initiated_by = $data['initiated_by'];
		$journal->amount = $data['amount'];
		$journal->type = 'debit';
		$journal->description = $data['description'];
		$journal->save();

		if(isset($data['mid'])){
        $membersfee = Memberfee::where('id',$data['mid'])->first();
        $membersfee->equity_debit_journal_id = $journal->id;
        $membersfee->update();
		}
        
        if(isset($data['tid'])){
		$tlb = Tlbpayment::where('id',$data['tid'])->first();
        $tlb->equity_debit_journal_id = $journal->id;
        $tlb->update();
         }

        }

	}


    public function updateCreditAccount($data,$trans_no){

        $journal = Journal::findOrFail($data['ajid']);

		$journal->void = 1;
		$journal->update();

        $journal = Journal::findOrFail($data['eqcid']);

		$journal->void = 1;
		$journal->update();

      
		$journal = new Journal;


		$account = Account::findOrFail($data['credit_account']);

		$journal->account()->associate($account);

		$journal->date = $data['date'];
		$journal->trans_no = $trans_no;
		$journal->initiated_by = $data['initiated_by'];
		$journal->amount = $data['amount'];
		$journal->type = 'credit';
		$journal->description = $data['description'];
		$journal->save();
      
       if(isset($data['incid']) && $data['description'] == 'Vehicles Incomes'){
          $vehicle = Vehicleincome::where('id',$data['incid'])->first();
          $vehicle->income_journal_id = $journal->id;
          $vehicle->update();

        }

		$journal = new Journal;
       
        $account = Account::findOrFail($data['equity_credit_account']);

		$journal->account()->associate($account);

		$journal->date = $data['date'];
		$journal->trans_no = $trans_no;
		$journal->initiated_by = $data['initiated_by'];
		$journal->amount = $data['offamt'];
		$journal->type = 'credit';
		$journal->description = "Office Contributions";
		$journal->save();
		
		if(isset($data['expid']) && $data['description'] == 'Vehicles Expenses'){
          $vehicle = Vehicleexpense::where('id',$data['expid'])->first();
          $vehicle->asset_journal_id = $journal->id;
          $vehicle->update();
        }else if(isset($data['incid']) && $data['description'] == 'Vehicles Incomes'){

          $vehicle = Vehicleincome::where('id',$data['incid'])->first();
          $vehicle->equity_credit_journal_id = $journal->id;
          $vehicle->update();

        }
	}



	public function updateDebitAccount($data,$trans_no){
        $journal = Journal::findOrFail($data['ejid']);

		$journal->void = 1;
		$journal->update();

        $journal = Journal::findOrFail($data['eqdid']);

		$journal->void = 1;
		$journal->update();

		$journal = new Journal;


		$account = Account::findOrFail($data['debit_account']);


	
		$journal->account()->associate($account);

		$journal->date = $data['date'];
		$journal->trans_no = $trans_no;
		$journal->initiated_by = $data['initiated_by'];
		$journal->amount = $data['amount'];
		$journal->type = 'debit';
		$journal->description = $data['description'];
		$journal->save();
        
        if(isset($data['incid']) && $data['description'] == 'Vehicles Incomes'){
          $vehicle = Vehicleincome::where('id',$data['incid'])->first();
          $vehicle->asset_journal_id = $journal->id;
          $vehicle->update();

        }

        $journal = new Journal;
       
        $account = Account::findOrFail($data['equity_debit_account']);

		$journal->account()->associate($account);

		$journal->date = $data['date'];
		$journal->trans_no = $trans_no;
		$journal->initiated_by = $data['initiated_by'];
		$journal->amount = $data['offamt'];
		$journal->type = 'debit';
		$journal->description = "Office Contributions";
		$journal->save();

		 if(isset($data['expid']) && $data['description'] == 'Vehicles Expenses'){
          $vehicle = Vehicleexpense::where('id',$data['expid'])->first();
          $vehicle->expense_journal_id = $journal->id;
          $vehicle->update();
        }else if(isset($data['incid']) && $data['description'] == 'Vehicles Incomes'){

          $vehicle = Vehicleincome::where('id',$data['incid'])->first();
          $vehicle->equity_debit_journal_id = $journal->id;
          $vehicle->update();

        }

	}

	public function updateCreditEquityAccount($data, $trans_no){

     if(isset($data['equity_member_credit_account'])){

        $journal = Journal::findOrFail($data['equity_update_credit_account']);

		$journal->void = 1;
		$journal->update();

        $journal = new Journal;
       
        $account = Account::findOrFail($data['equity_member_credit_account']);

		$journal->account()->associate($account);

		$journal->date = $data['date'];
		$journal->trans_no = $trans_no;
		$journal->initiated_by = $data['initiated_by'];
		$journal->amount = $data['amount'];
		$journal->type = 'credit';
		$journal->description = $data['description'];
		$journal->save();

		if(isset($data['mid'])){
        $membersfee = Memberfee::where('id',$data['mid'])->first();
        $membersfee->equity_credit_journal_id = $journal->id;
        $membersfee->update();
		}
        
        if(isset($data['tid'])){
		$tlb = Tlbpayment::where('id',$data['tid'])->first();
        $tlb->equity_credit_journal_id = $journal->id;
        $tlb->update();
         }

        }

		
	}


	public function updateDebitEquityAccount($data,$trans_no){

        if(isset($data['equity_member_debit_account'])){

        $journal = Journal::findOrFail($data['equity_update_debit_account']);

		$journal->void = 1;
		$journal->update();

        $journal = new Journal;
       
        $account = Account::findOrFail($data['equity_member_debit_account']);

		$journal->account()->associate($account);

		$journal->date = $data['date'];
		$journal->trans_no = $trans_no;
		$journal->initiated_by = $data['initiated_by'];
		$journal->amount = $data['amount'];
		$journal->type = 'debit';
		$journal->description = $data['description'];
		$journal->save();

		if(isset($data['mid'])){
        $membersfee = Memberfee::where('id',$data['mid'])->first();
        $membersfee->equity_debit_journal_id = $journal->id;
        $membersfee->update();
		}
        
        if(isset($data['tid'])){
		$tlb = Tlbpayment::where('id',$data['tid'])->first();
        $tlb->equity_debit_journal_id = $journal->id;
        $tlb->update();
         }

        }

	}


}