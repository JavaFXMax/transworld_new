<?php

class VehicleIncomesController extends \BaseController {

	/**
	 * Display a listing of accounts
	 *
	 * @return Response
	 */
	public function index()
	{
		$vehicles = Vehicleincome::all();

		return View::make('vehicleincomes.index', compact('vehicles'));
	}

	/**
	 * Show the form for creating a new account
	 *
	 * @return Response
	 */
	public function create()
	{
		$vehicles = Vehicle::all();
		$ainc     = Account::where('category','LIABILITY')->get();
		$asset    = Account::where('category','ASSET')->get();
		$equities    = Account::where('category','EQUITY')->get();

		return View::make('vehicleincomes.create', compact('vehicles','ainc','asset','equities'));
	}

	/**
	 * Store a newly created account in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Vehicleincome::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}
		/*Record Additional Payments*/
        $assign = Vehicle::where('id',Input::get('vehicle_id'))->first();
        $sum_amount=0;
        for ($i=0; $i <count(array_get($data, 'payment_names')) ; $i++) {
            if((array_get($data, 'payment_names')[$i] != '' ||
                array_get($data, 'payment_names')[$i] != null)){
                $date = Input::get('date');
                $saving = Savingaccount::where('member_id',$assign->member_id)
                    ->first();
                $savingaccount = Savingaccount::findOrFail($saving->id);

                $date = Input::get('date');

                $saving_amount =  array_get($data, 'amount')[$i];
                $type = "credit";
                $description = array_get($data, 'payment_names')[$i]. " from vehicle income";
                $transacted_by = Confide::user()->username;
                $category = 'Vehicle';
                $member = $assign->member_id;

                $savingtransaction = new Savingtransaction;

                $savingtransaction->date = $date;
                $savingtransaction->savingaccount()->associate($savingaccount);
                $savingtransaction->amount = $saving_amount;
                $savingtransaction->type = $type;
                $savingtransaction->description = $description;
                $savingtransaction->transacted_by = $transacted_by;
                $savingtransaction->void = 0;
                if($type == 'credit'){
                     $savingtransaction->payment_via = $category;
                }
                $savingtransaction->save();

                $vehsav = Vehicleincome::where('id',$assign->id)->first();
                $vehsav->savingtransaction_id = $savingtransaction->id;
                $vehsav->update();
                $vid = $assign->id;

                Savingtransaction::vtransact($date, $savingaccount, $category, $saving_amount, $type, $description, $transacted_by,$member,$vid);
              }
            $sum_amount+=array_get($data, 'amount')[$i];
        }
		// check if code exists
        $total_amount= Input::get('offamt') + Input::get('fee_amount') + Input::get('shares') + Input::get('petrol_investment') + Input::get('loans') + Input::get('savings') + Input::get('insurance')+ $sum_amount;
		$assign = Vehicle::where('id',Input::get('vehicle_id'))->first();
        /*Record Total Income*/
		$vehicle = new Vehicleincome;
        $vehicle->vehicle_id = $assign->id;
        $vehicle->member_id = $assign->member_id;
		$vehicle->amount  = $total_amount;
		$vehicle->date = Input::get('date');
		$vehicle->asset_account_id = Input::get('asset_id');
		$vehicle->income_account_id = Input::get('ainc_id');
		$vehicle->equity_account_id = Input::get('eq_id');
        $vehicle->save();

        $cont = 0;
        /*Record Vehicle Daily Contribution*/
        if(Input::get('offamt') > 0 || Input::get('offamt') != null ){
            $offm = str_replace( ',', '', Input::get('offamt'));
            $veh = Vehicle::findOrFail(Input::get('vehicle_id'));

            $contribution = new Contribution;
            $contribution->member_id = $veh->member_id;
            $contribution->vehicleincome_id = $vehicle->id;
            $contribution->amount = str_replace( ',', '', Input::get('offamt'));
            $contribution->date = Input::get('date');
            $contribution->is_void = 0;
            $contribution->save();

            $cont = $contribution->id;
        }
        /*Record Savings/Commissions*/
        $date = Input::get('date');
		$saving = Savingaccount::where('member_id',$assign->member_id)
            ->first();
		$savingaccount = Savingaccount::findOrFail($saving->id);
		$date = Input::get('date');

		$saving_amount = Input::get('savings');
		$type = "credit";
		$description = "Savings/Commissions from vehicle income";
		$transacted_by = Confide::user()->username;
		$category = 'Vehicle';
		$member = $assign->member_id;

		$savingtransaction = new Savingtransaction;
		$savingtransaction->date = $date;
		$savingtransaction->savingaccount()->associate($savingaccount);
		$savingtransaction->amount = $saving_amount;
		$savingtransaction->type = $type;
		$savingtransaction->description = $description;
		$savingtransaction->transacted_by = $transacted_by;
		$savingtransaction->void = 0;
		if($type == 'credit'){
             $savingtransaction->payment_via = $category;
        }
        $savingtransaction->save();

        $vehsav = Vehicleincome::where('id',$vehicle->id)->first();
        $vehsav->savingtransaction_id = $savingtransaction->id;
        $vehsav->update();
        $vid = $vehicle->id;

        Savingtransaction::vtransact($date, $savingaccount, $category, $saving_amount, $type, $description, $transacted_by,$member,$vid);
        /*Record Loan Repayment*/
        if(!empty(Input::get('loanproduct_id'))){
            if(!empty(Input::get('loans')) ){
                $loanamt = str_replace( ',', '', Input::get('loans'));
            }else{
                $loanamt = 0.00;
            }
            $loanaccount_id = Input::get('loanproduct_id');
            Loanrepayment::vrepayLoan($loanamt,$loanaccount_id,$member,$vid);
        }
        /*Record Shares*/
        if(Input::get('shares') != 0.00 || !empty(Input::get('shares'))){
            $share = Shareaccount::where('member_id',$assign->member_id)
                ->first();
            $shareaccount = Shareaccount::findOrFail($share->id);
            /*Record the share transaction*/
            $sharetransaction = new Sharetransaction;
            $sharetransaction->date = date("Y-m-d");
            $sharetransaction->shareaccount()->associate($shareaccount);
						if(!empty(Input::get('shares'))){
								$sharetransaction->amount =Input::get('shares');
						}
            $sharetransaction->amount = 0;
            $sharetransaction->type = "credit";
            $sharetransaction->pay_for='shares';
            $sharetransaction->description = "Shares from vehicle income";
            $sharetransaction->save();

            $vehshare = Vehicleincome::where('id',$vehicle->id)->first();
            $vehshare->sharetransaction_id = $sharetransaction->id;
            $vehshare->update();
        }
        /*Petrol Station Investment*/
        $share3 = Shareaccount::where('member_id',$assign->member_id)
            ->first();
        $shareaccount3 = Shareaccount::findOrFail($share3->id);
		$sharetransaction3 = new Sharetransaction;
		$sharetransaction3->date = date("Y-m-d");
		$sharetransaction3->shareaccount()->associate($shareaccount3);
		if(!empty(Input::get('petrol_investment'))){
				$sharetransaction3->amount =Input::get('petrol_investment');
		}
		$sharetransaction3->amount =0;
		$sharetransaction3->type = "credit";
        $sharetransaction3->pay_for='petrol';
		$sharetransaction3->description = "Petrol Station Investment";
		$sharetransaction3->save();

		$vehshare3 = Vehicleincome::where('id',$vehicle->id)->first();
        $vehshare3->sharetransaction_id = $sharetransaction3->id;
        $vehshare3->update();
        /*Pick Accounts*/
        $acc = Account::where('name','Cash Account')->first();
        if(Input::get('petrol_investment') > 0 ){
            $data = array(
                'date' => array_get($data, 'date'),
                'debit_account' => array_get($data, 'asset_id'),
                'credit_account' => array_get($data, 'eq_id'),
                'description' => 'Petrol Station Investment',
                'amount' => Input::get('petrol_investment'),
                'initiated_by' => Confide::user()->username,
                'cid' => $cont
                );
            $journal = new Journal;
            $journal->journal_contentry($data);
        }
        /*Insurance Payment*/
        $share33 = Shareaccount::where('member_id',$assign->member_id)
            ->first();
        $shareaccount33 = Shareaccount::findOrFail($share33->id);
		$sharetransaction33 = new Sharetransaction;
		$sharetransaction33->date = date("Y-m-d");
		$sharetransaction33->shareaccount()->associate($shareaccount33);
		if(!empty(Input::get('insurance'))){
				$sharetransaction33->amount =Input::get('insurance');
		}
		$sharetransaction33->amount = 0;
		$sharetransaction33->type = "credit";
        $sharetransaction33->pay_for='others';
		$sharetransaction33->description = "Insurance Payment";
		$sharetransaction33->save();

		$vehshare33 = Vehicleincome::where('id',$vehicle->id)->first();
        $vehshare33->sharetransaction_id = $sharetransaction33->id;
        $vehshare33->update();
        //$acc= Account::where('category','=','Cash Account')->first();
        /*Membership Fee Payment*/
        $share333 = Shareaccount::where('member_id',$assign->member_id)
            ->first();
        $shareaccount333 = Shareaccount::findOrFail($share333->id);
		$sharetransaction333 = new Sharetransaction;
		$sharetransaction333->date = date("Y-m-d");
		$sharetransaction333->shareaccount()->associate($shareaccount333);
		if(!empty(Input::get('fee_amount'))){
				$sharetransaction333->amount =Input::get('fee_amount');
		}
		$sharetransaction333->amount = 0;
		$sharetransaction333->type = "credit";
        $sharetransaction333->pay_for= 'membership';
		$sharetransaction333->description = "Membership Fee Payment";
		$sharetransaction333->save();

		$vehshare333 = Vehicleincome::where('id',$vehicle->id)->first();
        $vehshare333->sharetransaction_id = $sharetransaction333->id;
        $vehshare333->update();
        /*Pick Accounts*/
        $acc = Account::where('name','Cash Account')->first();

        if(Input::get('offamt') > 0 ){
        	$dt = array(
        	'member_id'=>$assign->member_id,
        	'date'=>Input::get('date'),
        	'amount'=>Input::get('offamt'),
        	'type'=>'debit'
        	);
        }
        //Contribution::nadd($dt, Input::get('asset_id'), Input::get('ainc_id') );
		return Redirect::route('vehicleincomes.index');
	}

	/**
	 * Display the specified account.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$vehicle = Vehicle::findOrFail($id);

		return View::make('vehicleincomes.show', compact('vehicle'));
	}

	/**
	 * Show the form for editing the specified account.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$vehicle      = Vehicleincome::find($id);
		$veh          = Vehicle::where('id',$vehicle->vehicle_id)->first();
		$loanproducts = DB::table('loanaccounts')
                      ->join('loanproducts', 'loanaccounts.loanproduct_id', '=', 'loanproducts.id')
                      ->where('loanaccounts.member_id',$vehicle->member_id)
                      ->where('loanaccounts.is_approved',1)
                      ->where('loanaccounts.is_rejected',0)
                      ->select('loanaccounts.id as id','loanproducts.name as name')
                      ->get();
		$ainc        = Account::where('category','LIABILITY')->get();
		$asset       = Account::where('category','ASSET')->get();
		$equities    = Account::where('category','EQUITY')->get();
		$savingtransaction     = Savingtransaction::where('id',$vehicle->savingtransaction_id)->first();
		$sharetransaction      = Sharetransaction::where('id',$vehicle->sharetransaction_id)->first();
		$loantransaction       = Loantransaction::where('id',$vehicle->loantransaction_id)->first();
		$officecontribution    = Journal::where('id',$vehicle->equity_credit_journal_id)->first();
		$vehs = Vehicle::all();

		return View::make('vehicleincomes.edit', compact('veh','vehicle','loanproducts','equities','vehs','ainc','asset','savingtransaction','sharetransaction','loantransaction','officecontribution'));
	}

	/**
	 * Update the specified account in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$vehicle = Vehicleincome::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Vehicleincome::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

				$vid = $id;
        $assign = Vehicle::where('id',Input::get('vehicle_id'))->first();
        $vehicle->vehicle_id = Input::get('vehicle_id');
				$vehicle->amount     = str_replace( ',', '', Input::get('amount'));
				$vehicle->date = Input::get('date');
				$vehicle->asset_account_id = Input::get('asset_id');
				$vehicle->income_account_id = Input::get('ainc_id');
				$vehicle->equity_account_id = Input::get('eq_id');
				$vehicle->update();
        $lamt = 0.00;

				if(Input::get('loanproduct_id') != '' ){
		        $lamt = str_replace( ',', '', Input::get('loans'));
				}else{
		        $lamt = 0.00;
				}
        if(Input::get('offamt') > 0 ){
         $offm = str_replace( ',', '', Input::get('offamt'));


        $cont = Contribution::where('vehicleincome_id',$id)->first();
			$cont->is_void = 1;
			$cont->update();
		if($cont->debit_journal_id != null && $cont->credit_journal_id != null){
		$journal = Journal::findOrFail($cont->credit_journal_id);
        $journal->void = 1;
        $journal->update();

        $journal = Journal::findOrFail($cont->debit_journal_id);
        $journal->void = 1;
        $journal->update();
        }

        $contribution = new Contribution;
		$contribution->member_id = $assign->member_id;
		$contribution->vehicleincome_id = $id;
		$contribution->amount = str_replace( ',', '', Input::get('offamt'));
		$contribution->date = Input::get('date');
		if(Input::get('reasons') != null || Input::get('reasons') != ''){
			$contribution->type = 'credit';
		}else{
			$contribution->type = 'debit';
		}
		$contribution->is_void = 0;
		$contribution->reason = Input::get('reasons');
		$contribution->save();
        }else if(Input::get('offamt') <= 0 ){
         $offm = 200;

         $veh = Vehicle::findOrFail(Input::get('vehicle_id'));

        $cont = Contribution::where('vehicleincome_id',$id)->first();
		$cont->is_void = 1;
		$cont->update();

		if($cont->debit_journal_id != null && $cont->credit_journal_id != null){
		$journal = Journal::findOrFail($cont->credit_journal_id);
        $journal->void = 1;
        $journal->update();

        $journal = Journal::findOrFail($cont->debit_journal_id);
        $journal->void = 1;
        $journal->update();
        }

        $contribution = new Contribution;
		$contribution->member_id = $assign->member_id;
		$contribution->vehicleincome_id = $id;
		$contribution->amount = str_replace( ',', '', Input::get('offamt'));
		$contribution->date = Input::get('date');
		if(Input::get('reasons') != null || Input::get('reasons') != ''){
			$contribution->type = 'credit';
		}else{
			$contribution->type = 'debit';
		}
		$contribution->is_void = 0;
		$contribution->reason = Input::get('reasons');
		$contribution->save();
        }

        $amt = str_replace( ',', '', Input::get('amount'))-$lamt-$offm-str_replace( ',', '', Input::get('shares'));

        $date = Input::get('date');
		$transAmount = $amt;

		$saving = Savingaccount::where('member_id',$assign->member_id)->first();

		$savingaccount = Savingaccount::findOrFail($saving->id);
		$date = Input::get('date');
		$amount = 0.00;

		$amount = $amt;
		$type = "credit";
		$description = "Savings/Commissions from vehicle income";
		$transacted_by = Confide::user()->username;
		$category = 'Vehicle';
		$member = $assign->member_id;

		$saving = Savingtransaction::findOrFail($vehicle->savingtransaction_id);
        $saving->void = 1;
		$saving->update();

        $savingtransaction = new Savingtransaction;
		$savingtransaction->date = $date;
		$savingtransaction->savingaccount()->associate($savingaccount);
		$savingtransaction->amount = $amount;
		$savingtransaction->type = $type;
		$savingtransaction->description = $description;
		$savingtransaction->transacted_by = $transacted_by;
		$saving->void = 0;
		if($type == 'credit'){
         $savingtransaction->payment_via = $category;
		}
		$savingtransaction->save();

		$vehsav = Vehicleincome::where('id',$id)->first();
        $vehsav->savingtransaction_id = $savingtransaction->id;
        $vehsav->update();
        $vid = $vehicle->id;

		$journal = Journal::findOrFail($vehicle->savings_credit_journal_id);
        $journal->void = 1;
        $journal->update();

        $journal = Journal::findOrFail($vehicle->savings_debit_journal_id);
        $journal->void = 1;
        $journal->update();

		Savingtransaction::vtransact($date, $savingaccount, $category, $amount, $type, $description, $transacted_by,$member,$vid);

        if(Input::get('loanproduct_id') != '' ){
        $loanamt = str_replace( ',', '', Input::get('loans'));

		$loanaccount_id = Input::get('loanproduct_id');

		$journal = Journal::findOrFail($vehicle->interest_credit_journal_id);
        $journal->void = 1;
        $journal->update();

        $journal = Journal::findOrFail($vehicle->interest_debit_journal_id);
        $journal->void = 1;
        $journal->update();

        $journal = Journal::findOrFail($vehicle->principal_credit_journal_id);
        $journal->void = 1;
        $journal->update();

        $journal = Journal::findOrFail($vehicle->principal_debit_journal_id);
        $journal->void = 1;
        $journal->update();

        $journal = Loanrepayment::findOrFail($vehicle->loanrepayment_principal_id);
        $journal->void = 1;
        $journal->update();

        $journal = Loanrepayment::findOrFail($vehicle->loanrepayment_interest_id);
        $journal->void = 1;
        $journal->update();

        $journal = Loantransaction::findOrFail($vehicle->loantransaction_id);
        $journal->void = 1;
        $journal->update();


        Loanrepayment::vrepayLoan($loanamt,$loanaccount_id,$member,$vid);
    }


        if(Input::get('shares') != 0.00 || Input::get('shares') != ''){

		$sharetransaction    = Sharetransaction::findOrFail($vehicle->sharetransaction_id);
		$sharetransaction->date = date("Y-m-d");
		$sharetransaction->amount = str_replace( ',', '', Input::get('shares'));
		$sharetransaction->update();

		$vehshare = Vehicleincome::where('id',$id)->first();
        $vehshare->sharetransaction_id = $sharetransaction->id;
        $vehshare->update();

        }

        //Contribution::nadd($dt, Input::get('asset_id'), Input::get('ainc_id') );

        if(Input::get('offamt') > 0 ){


			$data = array(
			'date' => array_get($data, 'date'),
			'debit_account' => array_get($data, 'asset_id'),
			'credit_account' => array_get($data, 'eq_id'),
			'description' => 'office contribution',
			'amount' => Input::get('offamt'),
			'initiated_by' => Confide::user()->username,
			'cid' => $cont->id
			);

		$journal = new Journal;

		$journal->journal_contentry($data);
        }else if(Input::get('offamt') <= 0 ){

			$data = array(
			'date' => array_get($data, 'date'),
			'debit_account' => array_get($data, 'asset_id'),
			'credit_account' => array_get($data, 'eq_id'),
			'description' => 'office contribution',
			'amount' => 200,
			'initiated_by' => Confide::user()->username,
			'cid' => $cont->id
			);

		$journal = new Journal;

		$journal->journal_contentry($data);

        }





		return Redirect::route('vehicleincomes.index');
	}

	/**
	 * Remove the specified account from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $vehicle = Vehicleincome::findOrFail($id);
		$saving = Savingtransaction::findOrFail($vehicle->savingtransaction_id);
        $saving->void = 1;
		$saving->update();

		$contribution = Contribution::where('vehicleincome_id',$id)->first();
		$contribution->void = 1;
		$contribution->update();

		if($contribution->debit_journal_id != null && $contribution->credit_journal_id != null){
		$journal = Journal::findOrFail($contribution->credit_journal_id);
        $journal->void = 1;
        $journal->update();

        $journal = Journal::findOrFail($contribution->debit_journal_id);
        $journal->void = 1;
        $journal->update();
        }

		if($vehicle->loantransaction_id != null || $vehicle->loantransaction_id != '' || $vehicle->loantransaction_id != 0){

		$saving = Loantransaction::findOrFail($vehicle->loantransaction_id);
        $saving->void = 1;
		$saving->update();

		$saving = Loanrepayment::findOrFail($vehicle->loanrepayment_principal_id);
        $saving->void = 1;
		$saving->update();

		$saving = Loanrepayment::findOrFail($vehicle->loanrepayment_interest_id);
        $saving->void = 1;
		$saving->update();

		$journal = Journal::findOrFail($vehicle->interest_credit_journal_id);
        $journal->void = 1;
        $journal->update();

        $journal = Journal::findOrFail($vehicle->interest_debit_journal_id);
        $journal->void = 1;
        $journal->update();

        $journal = Journal::findOrFail($vehicle->principal_credit_journal_id);
        $journal->void = 1;
        $journal->update();

        $journal = Journal::findOrFail($vehicle->principal_debit_journal_id);
        $journal->void = 1;
        $journal->update();

	}

		$journal = Journal::findOrFail($vehicle->savings_credit_journal_id);
        $journal->void = 1;
        $journal->update();

        $journal = Journal::findOrFail($vehicle->savings_debit_journal_id);
        $journal->void = 1;
        $journal->update();

        $journal = Journal::findOrFail($vehicle->asset_journal_id);
        $journal->void = 1;
        $journal->update();

        $journal = Journal::findOrFail($vehicle->income_journal_id);
        $journal->void = 1;
        $journal->update();


        $journal = Journal::findOrFail($vehicle->equity_credit_journal_id);
        $journal->void = 1;
        $journal->update();

        $journal = Journal::findOrFail($vehicle->equity_debit_journal_id);
        $journal->void = 1;
        $journal->update();

		Vehicleincome::destroy($id);

		return Redirect::route('vehicleincomes.index');
	}

}
