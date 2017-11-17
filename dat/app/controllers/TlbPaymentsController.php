<?php

class TlbPaymentsController extends \BaseController {

	/**
	 * Display a listing of currencies
	 *
	 * @return Response
	 */
	public function index()
	{
		$tlbs = Tlbpayment::all();
		return View::make('tlbs.index', compact('tlbs'));
	}

	/**
	 * Show the form for creating a new currency
	 *
	 * @return Response
	 */
	public function create()
	{
		$equities    = Account::where('category','EQUITY')->get();
		$asset    = Account::where('category','ASSET')->get();
		$vehicles    = Vehicle::all();
		return View::make('tlbs.create',compact('equities','asset','vehicles'));
	}

	/**
	 * Store a newly created currency in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Tlbpayment::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$tlb = new Tlbpayment;
		$tlb->vehicle_id = Input::get('vehicle_id');
		$tlb->account_id = Input::get('eq_id');
		$tlb->asset_id = Input::get('asset_id');
		$tlb->amount = Input::get('amount');
		$tlb->date = Input::get('date');
		$tlb->save();

		$vehicle = Vehicle::findOrFail(Input::get('vehicle_id'));

		/*$contribution = new Contribution;
		$contribution->member_id = $vehicle->member_id;
		$contribution->tlbpayment_id = $tlb->id;
		$contribution->amount = str_replace( ',', '', Input::get('amount'));
		$contribution->date = Input::get('date');
		$contribution->type = 'debit';
		$contribution->void = 0;
		$contribution->save();*/

		$data = array(
						'equity_member_credit_account' => Input::get('eq_id'),
						'equity_member_debit_account' => Input::get('asset_id'),
						'amount' => str_replace( ',', '', Input::get('amount')),
						'initiated_by' => 'system',
						'date'=>Input::get('date'),
						'description' => 'TLB Payments',
						'tid'=>$tlb->id
					);
		

					$journal = new Journal;


					$journal->journal_equity($data);

		return Redirect::route('tlbpayments.index');
	}

	/**
	 * Display the specified currency.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$tlb = Tlbpayment::findOrFail($id);
		$equities    = Account::where('category','EQUITY')->get();

		return View::make('tlbpayments.show', compact('tlb','equities'));
	}

	/**
	 * Show the form for editing the specified currency.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$tlb = Tlbpayment::find($id);
        $equities    = Account::where('category','EQUITY')->get();
        $asset    = Account::where('category','ASSET')->get();
		
        $vehicles    = Vehicle::all();
		return View::make('tlbs.edit', compact('tlb','equities','asset','vehicles'));
	}

	/**
	 * Update the specified currency in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$tlb = Tlbpayment::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Tlbpayment::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$tlb->account_id = Input::get('eq_id');
		$tlb->asset_id = Input::get('asset_id');
		$tlb->amount = Input::get('amount');
		$tlb->date = Input::get('date');
		$tlb->update();

		$vehicle = Vehicle::findOrFail(Input::get('vehicle_id'));

		/*$cont = Contribution::where('tlbpayment_id',$id)->first();
		$cont->void = 1;
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
		$contribution->member_id = $vehicle->member_id;
		$contribution->tlbpayment_id = $id;
		$contribution->amount = str_replace( ',', '', Input::get('amount'));
		$contribution->date = Input::get('date');
		$contribution->type = 'debit';
		$contribution->void = 0;
		$contribution->save();
*/
		$data = array(
			            'equity_update_credit_account' => $tlb->equity_credit_journal_id,
			            'equity_update_debit_account' => $tlb->equity_debit_journal_id,
						'equity_member_credit_account' => Input::get('eq_id'),
						'equity_member_debit_account' => Input::get('asset_id'),
						'amount' => str_replace( ',', '', Input::get('amount')),
						'initiated_by' => 'system',
						'date'=>Input::get('date'),
						'description' => 'TLB Payments',
						'tid'=>$tlb->id
					);

					$journal = new Journal;


					$journal->journal_updateequity($data);

		return Redirect::route('tlbpayments.index');
	}

	/**
	 * Remove the specified currency from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        
        $tlb = Tlbpayment::find($id);

        /*$cont = Contribution::where('tlbpayment_id',$id)->first();
		$cont->void = 1;
		$cont->update();

		if($cont->debit_journal_id != null && $cont->credit_journal_id != null){
		$journal = Journal::findOrFail($cont->credit_journal_id);
        $journal->void = 1;
        $journal->update();

        $journal = Journal::findOrFail($cont->debit_journal_id);
        $journal->void = 1;
        $journal->update();
        }*/

        $journal = Journal::findOrFail($tlb->equity_credit_journal_id);

		$journal->void = 1;
		$journal->update();

		$journal = Journal::findOrFail($tlb->equity_debit_journal_id);

		$journal->void = 1;
		$journal->update();

		Tlbpayment::destroy($id);

		return Redirect::route('tlbpayments.index');
	}

}
