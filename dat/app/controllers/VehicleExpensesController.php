<?php

class VehicleExpensesController extends \BaseController {

	/**
	 * Display a listing of accounts
	 *
	 * @return Response
	 */
	public function index()
	{
		$vehicles = Vehicleexpense::all();

		return View::make('vehicleexpenses.index', compact('vehicles'));
	}

	/**
	 * Show the form for creating a new account
	 *
	 * @return Response
	 */
	public function create()
	{
		$vehicles = Vehicle::all();
		$aexp     = Account::where('category','EXPENSE')->get();
		$asset    = Account::where('category','ASSET')->get();
		return View::make('vehicleexpenses.create', compact('vehicles','aexp','asset'));
	}

	/**
	 * Store a newly created account in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Vehicleexpense::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}


		// check if code exists

		$assign = Vehicle::where('id',Input::get('vehicle_id'))->first();


		$vehicle = new Vehicleexpense;

        $vehicle->vehicle_id = Input::get('vehicle_id');
        $vehicle->member_id = $assign->member_id;
		$vehicle->amount  = str_replace( ',', '', Input::get('amount'));
		$vehicle->expenseincurred = Input::get('incur');
		$vehicle->date = Input::get('date');
		$vehicle->asset_account_id = Input::get('asset_id');
		$vehicle->expense_account_id = Input::get('aexp_id');
		$vehicle->save();

			$data = array(
						'credit_account' => Input::get('asset_id'),
						'debit_account' => Input::get('aexp_id'),
						'date' => Input::get('date'),
						'amount' => str_replace( ',', '', Input::get('amount')),
						'initiated_by' => 'system',
						'description' => 'Vehicles Expenses',
						'expid'=>$vehicle->id
					);


					$journal = new Journal;


					$journal->journal_entry($data);
	

		return Redirect::route('vehicleexpenses.index');
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
		$vehicle = Vehicleexpense::find($id);
		$aexp     = Account::where('category','EXPENSE')->get();
		$asset    = Account::where('category','ASSET')->get();
		$vehs = Vehicle::all();

		return View::make('vehicleexpenses.edit', compact('vehicle','vehs','aexp','asset'));
	}

	/**
	 * Update the specified account in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$vehicle = Vehicleexpense::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Vehicleexpense::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}
        $vehicle->vehicle_id = Input::get('vehicle_id');
		$vehicle->amount  = str_replace( ',', '', Input::get('amount'));
		$vehicle->expenseincurred = Input::get('incur');
		$vehicle->date = Input::get('date');
		$vehicle->asset_account_id = Input::get('asset_id');
		$vehicle->expense_account_id = Input::get('aexp_id');
		$vehicle->update();
		
		$data = array(
						'credit_account' => Input::get('asset_id'),
						'debit_account' => Input::get('aexp_id'),
						'date' => Input::get('date'),
						'amount' => str_replace( ',', '', Input::get('amount')),
						'initiated_by' => 'system',
						'description' => 'Vehicles Expenses',
						'ajid' => $vehicle->asset_journal_id,
						'ejid' => $vehicle->expense_journal_id,
						'expid'=>$vehicle->id
					);


					$journal = new Journal;


					$journal->journal_update($data);

		return Redirect::route('vehicleexpenses.index');
	}

	/**
	 * Remove the specified account from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Vehicleexpense::destroy($id);

		return Redirect::route('vehicleexpenses.index');
	}

}
