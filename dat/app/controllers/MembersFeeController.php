<?php

class MembersFeeController extends \BaseController {

	/**
	 * Display a listing of currencies
	 *
	 * @return Response
	 */
	public function index()
	{
		$memberfees = Memberfee::all();
        $equities    = Account::where('category','EQUITY')->get();
		return View::make('membersfee.index', compact('memberfees','equities'));
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
		return View::make('membersfee.create',compact('equities','asset'));
	}

	/**
	 * Store a newly created currency in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Memberfee::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$membersfee = new Memberfee;
		$membersfee->member_registration_fee = Input::get('member_registration_fee');
		$membersfee->account_id = Input::get('eq_id');
		$membersfee->asset_id = Input::get('asset_id');
		$membersfee->save();

		$data = array(
						'equity_member_credit_account' => Input::get('eq_id'),
						'equity_member_debit_account' => Input::get('asset_id'),
						'amount' => str_replace( ',', '', Input::get('member_registration_fee')),
						'initiated_by' => 'system',
						'date'=>date('Y-m-d'),
						'description' => 'Member Registration Fee',
						'mid'=>$membersfee->id
					);

					$journal = new Journal;


					$journal->journal_equity($data);

		return Redirect::route('membersfee.index');
	}

	/**
	 * Display the specified currency.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$memberfee = Memberfee::findOrFail($id);
		$equities    = Account::where('category','EQUITY')->get();

		
		return View::make('membersfee.show', compact('memberfee','equities'));
	}

	/**
	 * Show the form for editing the specified currency.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$membersfee = Memberfee::find($id);
        $equities    = Account::where('category','EQUITY')->get();
        $asset    = Account::where('category','ASSET')->get();
		return View::make('membersfee.edit', compact('membersfee','equities','asset'));
	}

	/**
	 * Update the specified currency in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$membersfee = Memberfee::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Memberfee::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$membersfee->member_registration_fee = Input::get('member_registration_fee');
		$membersfee->account_id = Input::get('eq_id');
		$membersfee->asset_id = Input::get('asset_id');
		$membersfee->update();

		$data = array(
			            'equity_update_credit_account' => $membersfee->equity_credit_journal_id,
			            'equity_update_debit_account' => $membersfee->equity_debit_journal_id,
						'equity_member_credit_account' => Input::get('eq_id'),
						'equity_member_debit_account' => Input::get('asset_id'),
						'amount' => str_replace( ',', '', Input::get('member_registration_fee')),
						'initiated_by' => 'system',
						'date'=>date('Y-m-d'),
						'description' => 'Member Registration Fee',
						'mid'=>$membersfee->id
					);

					$journal = new Journal;


					$journal->journal_updateequity($data);

		return Redirect::route('membersfee.index');
	}

	/**
	 * Remove the specified currency from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        
        $membersfee = Memberfee::find($id);

        $journal = Journal::findOrFail($membersfee->equity_credit_journal_id);

		$journal->void = 1;
		$journal->update();

		$journal = Journal::findOrFail($membersfee->equity_debit_journal_id);

		$journal->void = 1;
		$journal->update();

		Memberfee::destroy($id);

		return Redirect::route('membersfee.index');
	}

}
