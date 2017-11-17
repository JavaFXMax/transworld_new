<?php

class AssignVehiclesController extends \BaseController {

	/**
	 * Display a listing of accounts
	 *
	 * @return Response
	 */
	public function index()
	{
		$vehicles = Assignvehicle::all();

		return View::make('assignvehicles.index', compact('vehicles'));
	}

	/**
	 * Show the form for creating a new account
	 *
	 * @return Response
	 */
	public function create()
	{
		$vehicles = Vehicle::all();
		$members  = Member::all();
		return View::make('assignvehicles.create', compact('vehicles','members'));
	}

	/**
	 * Store a newly created account in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Assignvehicle::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}


		// check if code exists


		$vehicle = new Assignvehicle;

        $vehicle->vehicle_id = Input::get('vehicle_id');
		$vehicle->member_id  = Input::get('member_id');
		
		$vehicle->save();

		

		return Redirect::route('assignvehicles.index');
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

		return View::make('assignvehicles.show', compact('vehicle'));
	}

	/**
	 * Show the form for editing the specified account.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$vehicle = Assignvehicle::find($id);
		$vehs = Vehicle::all();
		$members  = Member::all();

		return View::make('assignvehicles.edit', compact('vehicle','vehs','members'));
	}

	/**
	 * Update the specified account in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$vehicle = Assignvehicle::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Assignvehicle::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}
        $vehicle->vehicle_id = Input::get('vehicle_id');
		$vehicle->member_id  = Input::get('member_id');
		
		$vehicle->update();
		
		

		return Redirect::route('assignvehicles.index');
	}

	/**
	 * Remove the specified account from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Assignvehicle::destroy($id);

		return Redirect::route('assignvehicles.index');
	}

}
