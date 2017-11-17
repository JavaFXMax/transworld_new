<?php

class LoanaccountsController extends \BaseController {

	/**
	 * Display a listing of loanaccounts
	 *
	 * @return Response
	 */
	public function index()
	{
		$loanaccounts = Loanaccount::all();

		return View::make('loanaccounts.index', compact('loanaccounts'));
	}

	public function guarantor()
	{
						$member = Member::where('membership_no',Confide::user()->username)->first();
						//$loanaccounts = Loanaccount::where('member_id',$member->id)->get();
		        $loanaccounts = DB::table('loanaccounts')
				               ->join('loanguarantors', 'loanaccounts.id', '=', 'loanguarantors.loanaccount_id')
				               ->join('loanproducts', 'loanaccounts.loanproduct_id', '=', 'loanproducts.id')
				               ->join('members', 'loanaccounts.member_id', '=', 'members.id')
				               ->where('loanguarantors.member_id',$member->id)
				               ->where('loanguarantors.is_approved','pending')
				               ->select('loanaccounts.id','members.name as mname','loanproducts.name as pname','application_date','amount_applied','repayment_duration','loanaccounts.interest_rate')
				               ->get();
						return View::make('css.loanindex', compact('loanaccounts'));
	}

	/**
	 * Show the form for creating a new loanaccount
	 *
	 * @return Response
	 */
	public function apply($id)
	{
					$member = Member::find($id);
					$guarantors = Member::where('id','!=',$id)->get();
					$loanproducts = Loanproduct::all();
					return View::make('loanaccounts.create', compact('member', 'guarantors', 'loanproducts'));
	}



	public function apply2($id)
	{
				$member = Member::find($id);
        $guarantors = Member::where('id','!=',$id)->get();
				$loanproducts = Loanproduct::all();
				return View::make('css.loancreate', compact('member', 'guarantors', 'loanproducts'));
	}

	/**
	 * Store a newly created loanaccount in storage.
	 *
	 * @return Response
	 */
	public function doapply()
	{
		$validator = Validator::make($data = Input::all(), Loanaccount::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Loanaccount::submitApplication($data);

		$id = array_get($data, 'member_id');

		return Redirect::to('loans');



	}



	public function doapply2()
	{
		$validator = Validator::make($data = Input::all(), Loanaccount::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Loanaccount::submitApplication($data);

		$id = array_get($data, 'member_id');

		return Redirect::to('memberloans')->withFlashMessage('Loan successfully applied!');;



	}


public function shopapplication()
	{

		$data =Input::all();








		Loanaccount::submitShopApplication($data);



		//$id = array_get($data, 'member_id');

		return Redirect::to('memberloans');



	}

	/**
	 * Display the specified loanaccount.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$loanaccount = Loanaccount::findOrFail($id);
		$interest = Loanaccount::getInterestAmount($loanaccount);
		$loanbalance = Loantransaction::getLoanBalance($loanaccount);
		$principal_paid = Loanrepayment::getPrincipalPaid($loanaccount);
		$interest_paid = Loanrepayment::getInterestPaid($loanaccount);
		$loanguarantors = $loanaccount->guarantors;

		$loantransactions = DB::table('loantransactions')->where('loanaccount_id', '=', $id)->where('void', '=', 0)->orderBy('id', 'DESC')->get();
		if(Confide::user()->user_type == 'member'){
		return View::make('css.loanscheduleshow', compact('loanaccount', 'loanguarantors', 'interest', 'principal_paid', 'interest_paid', 'loanbalance', 'loantransactions'));
	}else{
		return View::make('loanaccounts.show', compact('loanaccount', 'loanguarantors', 'interest', 'principal_paid', 'interest_paid', 'loanbalance', 'loantransactions'));
	}
	}




	public function show2($id)
	{
		$loanaccount = Loanaccount::findOrFail($id);
		$interest = Loanaccount::getInterestAmount($loanaccount);
		$loanbalance = Loantransaction::getLoanBalance($loanaccount);
		$principal_paid = Loanrepayment::getPrincipalPaid($loanaccount);
		$interest_paid = Loanrepayment::getInterestPaid($loanaccount);
		$loanguarantors = $loanaccount->guarantors;

		return View::make('css.loanshow', compact('loanaccount', 'loanguarantors', 'interest', 'principal_paid', 'interest_paid', 'loanbalance'));
	}

	/**
	 * Show the form for editing the specified loanaccount.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$loanaccount = Loanaccount::find($id);

		return View::make('loanaccounts.edit', compact('loanaccount'));
	}

	/**
	 * Update the specified loanaccount in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$loanaccount = Loanaccount::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Loanaccount::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$loanaccount->update($data);

		return Redirect::route('loanaccounts.index');
	}

	/**
	 * Remove the specified loanaccount from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Loanaccount::destroy($id);

		return Redirect::route('loanaccounts.index');
	}




	public function approve($id)
	{
		$loanaccount = Loanaccount::find($id);

		return View::make('loanaccounts.approve', compact('loanaccount'));
	}

	/**
	 * Update the specified loanaccount in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function doapprove($id)
	{
		//$loanaccount =  new Loanaccount;

		$validator = Validator::make($data = Input::all(), Loanaccount::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		//$loanaccount->approve($data);


		$loanaccount_id = array_get($data, 'loanaccount_id');
		$loanaccount = Loanaccount::findorfail($loanaccount_id);
		$loanaccount->date_approved = array_get($data, 'date_approved');
		$loanaccount->amount_approved = array_get($data, 'amount_approved');
		//$loanaccount->amount_to_pay = (array_get($data, 'amount_approved')*array_get($data, 'interest_rate')/100)+array_get($data, 'amount_approved');
		$loanaccount->interest_rate = array_get($data, 'interest_rate');
		$loanaccount->period = array_get($data, 'period');
		$loanaccount->is_approved = TRUE;
		$loanaccount->is_new_application = FALSE;
		$loanaccount->update();
		return Redirect::route('loans.index');
	}


	public function guarantorapprove($id)
	{
		//$loanaccount =  new Loanaccount;

		$validator = Validator::make($data = Input::all(), loanguarantor::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		//$loanaccount->approve($data);

		$member = Member::where('membership_no',Confide::user()->username)->first();

		$loanguarantor = loanguarantor::where('loanaccount_id',$id)->where('member_id',$member->id)->first();
		$lg = loanguarantor::findOrFail($loanguarantor->id);
        $lg->amount = array_get($data, 'amount');
        $lg->is_approved = 'approved';
        $lg->date = date('Y-m-d');
		$lg->update();


        include(app_path() . '\views\AfricasTalkingGateway.php');
		$mem_id = array_get($data, 'mid');

		$member1 = Member::findOrFail($mem_id);


    // Specify your login credentials
    $username   = "kenkode";
    $apikey     = "7876fef8a4303ec6483dfa47479b1d2ab1b6896995763eeb620b697641eba670";
    // Specify the numbers that you want to send to in a comma-separated list
    // Please ensure you include the country code (+254 for Kenya in this case)
    $recipients = $member1->phone;
    // And of course we want our recipients to know what we really do
    $message    = "Hello ".$member1->name."!  Member ".$member->name." has approved your loan for Ksh. ".array_get($data, 'amount_applied')." for loan product ".array_get($data, 'pname')." and has agreed to be your guarantor and has guranteed an amount of Ksh. ".array_get($data, 'amount').".
    Please wait for final approval from the managements of the sacco so as to get the loan.
    Thank you!";
    // Create a new instance of our awesome gateway class
    $gateway    = new AfricasTalkingGateway($username, $apikey);
    // Any gateway error will be captured by our custom Exception class below,
    // so wrap the call in a try-catch block
    try
    {
      // Thats it, hit send and we'll take care of the rest.
      $results = $gateway->sendMessage($recipients, $message);

      /*foreach($results as $result) {
        // status is either "Success" or "error message"
        echo " Number: " .$result->number;
        echo " Status: " .$result->status;
        echo " MessageId: " .$result->messageId;
        echo " Cost: "   .$result->cost."\n";
      }*/
    }
    catch ( AfricasTalkingGatewayException $e )
    {
      echo "Encountered an error while sending: ".$e->getMessage();
    }


		return Redirect::to('/guarantorapproval')->withFlashMessage('You have successfully approved member loan!');
	}

    public function guarantorreject($id)
	{
		//$loanaccount =  new Loanaccount;

		$validator = Validator::make($data = Input::all(), loanguarantor::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		//$loanaccount->approve($data);


		$member = Member::where('membership_no',Confide::user()->username)->first();

		$loanguarantor = loanguarantor::where('loanaccount_id',$id)->where('member_id',$member->id)->first();
		$lg = loanguarantor::findOrFail($loanguarantor->id);
        $lg->is_approved = 'rejected';
        $lg->date = date('Y-m-d');
		$lg->update();


        include(app_path() . '\views\AfricasTalkingGateway.php');
		$mem_id = array_get($data, 'mid1');

		$member1 = Member::findOrFail($mem_id);


    // Specify your login credentials
    $username   = "kenkode";
    $apikey     = "7876fef8a4303ec6483dfa47479b1d2ab1b6896995763eeb620b697641eba670";
    // Specify the numbers that you want to send to in a comma-separated list
    // Please ensure you include the country code (+254 for Kenya in this case)
    $recipients = $member1->phone;
    // And of course we want our recipients to know what we really do
    $message    = "Hello ".$member1->name."!  Member ".$member->name." has rejected your loan for Ksh. ".array_get($data, 'amount_applied1')." for loan product ".array_get($data, 'pname1').".
    Thank you!";
    // Create a new instance of our awesome gateway class
    $gateway    = new AfricasTalkingGateway($username, $apikey);
    // Any gateway error will be captured by our custom Exception class below,
    // so wrap the call in a try-catch block
    try
    {
      // Thats it, hit send and we'll take care of the rest.
      $results = $gateway->sendMessage($recipients, $message);

      /*foreach($results as $result) {
        // status is either "Success" or "error message"
        echo " Number: " .$result->number;
        echo " Status: " .$result->status;
        echo " MessageId: " .$result->messageId;
        echo " Cost: "   .$result->cost."\n";
      }*/
    }
    catch ( AfricasTalkingGatewayException $e )
    {
      echo "Encountered an error while sending: ".$e->getMessage();
    }


		return Redirect::to('/guarantorapproval')->withDeleteMessage('You have successfully rejected member loan!');
	}

	public function reject($id)
	{
		$loanaccount = Loanaccount::find($id);

		return View::make('loanaccounts.reject', compact('loanaccount'));
	}


	public function rejectapplication()
	{

		$validator = Validator::make($data = Input::all(), Loanaccount::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}



		$loanaccount_id = array_get($data, 'loanaccount_id');



		$loanaccount = Loanaccount::findorfail($loanaccount_id);

		$loanaccount->rejection_reason = array_get($data, 'reasons');
		$loanaccount->is_rejected = TRUE;
		$loanaccount->is_approved = FALSE;
		$loanaccount->is_new_application = FALSE;
		$loanaccount->update();

		return Redirect::route('loans.index');
	}





	public function disburse($id)
	{
		$loanaccount = Loanaccount::find($id);

		return View::make('loanaccounts.disburse', compact('loanaccount'));
	}

	/**
	 * Update the specified loanaccount in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function dodisburse($id)
	{
		//$loanaccount =  new Loanaccount;
		$validator = Validator::make($data = Input::all(), Loanaccount::$rules);
		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}
		//$loanaccount->approve($data);
		$loanaccount_id = array_get($data, 'loanaccount_id');
		$loanaccount = Loanaccount::findorfail($loanaccount_id);
		$amount = array_get($data, 'amount_disbursed');
		$date = array_get($data, 'date_disbursed');
		$loanaccount->date_disbursed = $date;
		$loanaccount->amount_disbursed = $amount;
		$loanaccount->repayment_start_date = array_get($data, 'repayment_start_date');
		$loanaccount->account_number = Loanaccount::loanAccountNumber($loanaccount);
		$loanaccount->is_disbursed = TRUE;
		$loanaccount->update();
		$loanamount = $amount + Loanaccount::getInterestAmount($loanaccount);
		Loantransaction::disburseLoan($loanaccount, $loanamount, $date);
		return Redirect::route('loans.index');
	}


	public function gettopup($id){
		$loanaccount = Loanaccount::findOrFail($id);
		//$topups=Topup::where('loanaccount_id',$id)->get(); Was for Buruburu
		return View::make('loanaccounts.topup', compact('loanaccount'));
	}



	public function topup($id){
				$data = Input::all();
        $amount=$data['amount'];
				$date=$data['top_up_date'];
				//include the new function here
				$loanaccount = Loanaccount::findOrFail($data['loanaccount']);
        /*Get Loan Balance*/
        $loan_balance= Loantransaction::getLoanBalance($loanaccount);
        /*110% of Loan Balance*/
        $amount_to_top= 1.1 * $loan_balance;
        $sacco_income= 0.1 * $loan_balance;
        if($amount <= $amount_to_top){
            return Redirect::back()->withCaution('Top up amount should be greater than
            110% of the loan balance');
        }
        /*Pay Remaining Balance*/
        $transaction = new Loantransaction;
				$transaction->loanaccount()->associate($loanaccount);
				$transaction->date = $date;
				$transaction->description = 'loan repayment';
				$transaction->amount = $loan_balance;
				$transaction->type = 'credit';
				$transaction->payment_via = 'Cash';
				$transaction->save();
        /*Make a journal Entry*/
        $journal = new Journal;
        $account = Account::where('category','=','INCOME')->get()->first();
				$journal->account()->associate($account);
				$journal->date = $date;
				$journal->trans_no = strtotime($date);
				$journal->initiated_by = Confide::user()->username;
				$journal->amount = $sacco_income;
				$journal->type = 'credit';
				$journal->description = "Loan Top Up Charge";
				$journal->save();
        /*Create a Separate Loan Account*/
        if($amount >0){
            $loanaccount_topped= new Loanaccount;
            $loanaccount_topped->is_new_application= FALSE;
            $loanaccount_topped->member_id=$loanaccount->member_id;
            $loanaccount_topped->loanproduct_id=$loanaccount->loanproduct_id;
            $loanaccount_topped->application_date = $date;
            $loanaccount_topped->amount_applied = $amount;
                /*Get Loan Insurance*/
                $insurance =Loanaccount::getInsurance($loanaccount->repayment_duration, $amount);
                $amount_taken = $amount- $insurance;
                /*Record Insurance as income*/
                $insurance_journal= new Journal;
                $account = Account::where('category','=','INCOME')->get()->first();
                $insurance_journal->account()->associate($account);
                $insurance_journal->date = $date;
                $insurance_journal->trans_no = strtotime($date);
                $insurance_journal->initiated_by = Confide::user()->username;
                $insurance_journal->amount = $insurance;
                $insurance_journal->type = 'credit';
                $insurance_journal->description = "Loan Insurance Fee";
                $insurance_journal->save();
            $loanaccount_topped->interest_rate = $loanaccount->interest_rate;
            $loanaccount_topped->period = $loanaccount->period;
            $loanaccount_topped->repayment_duration = $loanaccount->repayment_duration;
            $loanaccount_topped->account_number = Loanaccount::loanAccountNumber($loanaccount);
            $loanaccount_topped->is_approved=TRUE;
            $loanaccount_topped->amount_approved=$amount_taken;
            $loanaccount_topped->is_disbursed=TRUE;
            $loanaccount_topped->amount_disbursed=$amount_taken;
            $loanaccount_topped->date_disbursed=$date;
            $loanaccount_topped->save();

            Loantransaction::disburseLoan($loanaccount_topped, $amount_taken, $date);
        }
				//Loantransaction::topupLoan($loanaccount, $top_up_amount, $date);
				return Redirect::to('loans/show/'.$loanaccount_topped->id);
	}

	public function topupReport($id){
					$topups=Topup::where('loanaccount_id',$id)->get();
					$loanaccount=Loanaccount::find($id);
			    $organization = Organization::find(1);
			    $pdf = PDF::loadView('pdf.loanreports.topups', compact('topups','loanaccount', 'organization'))
			    ->setPaper('a4')->setOrientation('potrait');
			    return $pdf->stream('Top Up Report.pdf');
	}

}
