<?php

class ContributionsController extends \BaseController {

	/**
	 * Display a listing of contributions
	 *
	 * @return Response
	 */
	public function index()
	{
		$contributions = Contribution::all();

		return View::make('contributions.index', compact('contributions'));
	}

	/**
	 * Show the form for creating a new contribution
	 *
	 * @return Response
	 */
	public function create($id)
	{
		$member = Member::find($id);
		$assets    = Account::where('category','ASSET')->get();
		$equities    = Account::where('category','EQUITY')->get();

		return View::make('contributions.create', compact('member', 'assets', 'equities'));
	}

	/**
	 * Store a newly created contribution in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Contribution::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$memberid = array_get($data, 'member_id');

		Contribution::add($data);

		return Redirect::to('member/contributions/'.$memberid);
	}

	/**
	 * Display the specified contribution.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$member = Member::find($id);
		$contributions = Contribution::where('member_id', $id)->where('is_void',false)->get();

		return View::make('contributions.show', compact('contributions', 'member'));
	}

	/**
	 * Show the form for editing the specified contribution.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$contribution = Contribution::find($id);

		return View::make('contributions.edit', compact('contribution'));
	}

	/**
	 * Update the specified contribution in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$contribution = Contribution::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Contribution::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$contribution->update($data);

		return Redirect::route('contributions.index');
	}

	/**
	 * Remove the specified contribution from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$cont = Contribution::find($id);

		$cont->is_void = true;
		$cont->update();

        if($cont->debit_journal_id != null && $cont->credit_journal_id != null){
		$journal = Journal::findOrFail($cont->credit_journal_id);
        $journal->void = 1;
        $journal->update();

        $journal = Journal::findOrFail($cont->debit_journal_id);
        $journal->void = 1;
        $journal->update();
        }

		return Redirect::back()->with('notice', 'contribution has been voided');
	}


	public function statement($id){

		$organization = Organization::find(1);
  		$member = Member::find($id);
  		$contributions = Contribution::where('member_id', $id)->where('is_void',false)->get();
   
    	$pdf = PDF::loadView('pdf.contributionstatement', compact('member', 'organization', 'contributions'))->setPaper('a4')->setOrientation('potrait');
  
    	return $pdf->stream('Contributionstatement.pdf');
	}

}
