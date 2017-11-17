<?php

class VehiclesController extends \BaseController {

	/**
	 * Display a listing of accounts
	 *
	 * @return Response
	 */
	public function index()
	{
		$vehicles = Vehicle::all();

		return View::make('vehicles.index', compact('vehicles'));
	}

	/**
	 * Show the form for creating a new account
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('vehicles.create');
	}

    public function addVehicle($id){
        $member = Member::where('id','=',$id)->first();
        $charges = Charge::where('category', 'member')->get();
        return View::make('vehicles.add', compact('member','charges'));
    }
    
    public function addedVehicle(){
        $validator = Validator::make($data = Input::all(), Vehicle::$rules);

		if ($validator->fails()){
			return Redirect::back()->withErrors($validator)->withInput();
		}
		// check if code exists
		$vehicle = new Vehicle;

        $vehicle->make = Input::get('make');
		$vehicle->regno = Input::get('regno');
		$vehicle->member_id = Input::get('member');
        $vehicle->registration_fee = Input::get('registration');
		$vehicle->save();
        $member =Input::get('member');
        return Redirect::route('members.show',compact('member'));
    }
	/**
	 * Store a newly created account in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Vehicle::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}


		// check if code exists


		$vehicle = new Vehicle;

        $vehicle->make = Input::get('make');
		$vehicle->regno = Input::get('regno');
		
		$vehicle->save();

		
		return Redirect::route('vehicles.index');
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

		return View::make('vehicles.show', compact('vehicle'));
	}

	/**
	 * Show the form for editing the specified account.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$vehicle = Vehicle::find($id);

		return View::make('vehicles.edit', compact('vehicle'));
	}

	/**
	 * Update the specified account in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$vehicle = Vehicle::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Vehicle::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}
        $vehicle->make = Input::get('make');
		$vehicle->regno = Input::get('regno');
		
		$vehicle->update();
		
		

		return Redirect::route('vehicles.index');
	}

	/**
	 * Remove the specified account from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Vehicle::destroy($id);

		return Redirect::route('vehicles.index');
	}

}
