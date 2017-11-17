<?php

class SharetransactionsController extends \BaseController {

	/**
	 * Display a listing of sharetransactions
	 *
	 * @return Response
	 */
	public function index()
	{
		$sharetransactions = Sharetransaction::all();

		return View::make('sharetransactions.index', compact('sharetransactions'));
	}

	/**
	 * Show the form for creating a new sharetransaction
	 *
	 * @return Response
	 */
	public function create($id)
	{


		$shareaccount = Shareaccount::findOrFail($id);

		$member = $shareaccount->member;

		return View::make('sharetransactions.create', compact('shareaccount', 'member'));


	}

	/**
	 * Store a newly created sharetransaction in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
						$validator = Validator::make($data = Input::all(), Sharetransaction::$rules);
						if ($validator->fails()){
										return Redirect::back()->withErrors($validator)->withInput();
						}
						/*Get Member Share Account*/
						$shareaccount = Shareaccount::findOrFail(Input::get('account_id'));
		        /*Pay Membership Fee*/
						$sharetransaction = new Sharetransaction;
						$sharetransaction->date = Input::get('date');
						$sharetransaction->shareaccount()->associate($shareaccount);
				    if(!empty(Input::get('fee_amount'))){
					 					$sharetransaction->amount =Input::get('fee_amount');
				     }
						 if(empty(Input::get('fee_amount'))){
							 			$sharetransaction->amount =0;
 				     }
						$sharetransaction->type = Input::get('type');
		        $sharetransaction->pay_for = 'membership';
						$sharetransaction->description = Input::get('description');
						$sharetransaction->save();
		        /*Pay Share Capital*/
						$sharetransaction1 = new Sharetransaction;
						$sharetransaction1->date = Input::get('date');
						$sharetransaction1->shareaccount()->associate($shareaccount);
		        if(!empty(Input::get('amount') )){
									$sharetransaction1->amount = Input::get('amount');
		        }
						if(empty(Input::get('amount'))){
									$sharetransaction1->amount = 0;
		        }
						$sharetransaction1->type = Input::get('type');
		        $sharetransaction1->pay_for = 'shares';
						$sharetransaction1->description = Input::get('description');
						$sharetransaction1->save();
						/*Petrol Station Investment*/
						$sharetransaction2= new Sharetransaction;
						$sharetransaction2->date = Input::get('date');
						$sharetransaction2->shareaccount()->associate($shareaccount);
						if(!empty(Input::get('petrol_investment'))){
								$sharetransaction2->amount =Input::get('petrol_investment');
		        }
						if(empty(Input::get('petrol_investment'))){
								$sharetransaction2->amount =0;
		        }
						$sharetransaction2->type = Input::get('type');
						$sharetransaction2->pay_for='petrol';
						$sharetransaction2->description = "Petrol Station Investment";
						$sharetransaction2->save();
						/*Redirect to loans.show view*/
						return Redirect::to('sharetransactions/show/'.$shareaccount->id);
	}

	/**
	 * Display the specified sharetransaction.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
						$account = Shareaccount::findOrFail($id);
						$petrol= DB::table('sharetransactions')->where('pay_for','=','petrol')->where('shareaccount_id', '=', $account->id)->where('type', '=', 'credit')->sum('amount');
						$membership= DB::table('sharetransactions')->where('pay_for','=','membership')->where('shareaccount_id', '=', $account->id)->where('type', '=', 'credit')->sum('amount');
						$share_capital = DB::table('sharetransactions')->where('pay_for','=','shares')->where('shareaccount_id', '=', $account->id)->where('type', '=', 'credit')->sum('amount');
						$others = DB::table('sharetransactions')->where('pay_for','=','others')->where('shareaccount_id', '=', $account->id)->where('type', '=', 'credit')->sum('amount');
						$credit = DB::table('sharetransactions')->where('shareaccount_id', '=', $account->id)->where('type', '=', 'credit')->sum('amount');
						$debit = DB::table('sharetransactions')->where('shareaccount_id', '=', $account->id)->where('type', '=', 'debit')->sum('amount');
						$balance = $credit - $debit;
						$shares = $balance;
						return View::make('sharetransactions.show', compact('account','petrol','membership','share_capital','others', 'shares'));
	}
	/**
	 * Show the form for editing the specified sharetransaction.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
				$sharetransaction = Sharetransaction::find($id);
				return View::make('sharetransactions.edit', compact('sharetransaction'));
	}

	/**
	 * Update the specified sharetransaction in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$sharetransaction = Sharetransaction::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Sharetransaction::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$sharetransaction->update($data);

		return Redirect::route('sharetransactions.index');
	}

	/**
	 * Remove the specified sharetransaction from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Sharetransaction::destroy($id);

		return Redirect::route('sharetransactions.index');
	}

}
