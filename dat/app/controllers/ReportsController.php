<?php

class ReportsController extends \BaseController {

	


	public function members(){

		$members = Member::all();

		$organization = Organization::find(1);

		$pdf = PDF::loadView('pdf.memberlist', compact('members', 'organization'))->setPaper('a4')->setOrientation('potrait');
 	
		return $pdf->stream('MemberList.pdf');
		
	}



	public function remittance(){

		//$members = DB::table('members')->where('is_active', '=', '1')->get();

		$members = Member::all();
		$organization = Organization::find(1);

		$savingproducts = Savingproduct::all();

		$loanproducts = Loanproduct::all();

		$pdf = PDF::loadView('pdf.remittance', compact('members', 'organization', 'loanproducts', 'savingproducts'))->setPaper('a4')->setOrientation('landscape');
 	
		return $pdf->stream('Remittance.pdf');
		
	}



	public function template(){

		$members = Member::all();

		$organization = Organization::find(1);

		$pdf = PDF::loadView('pdf.blank', compact('members', 'organization'))->setPaper('a4')->setOrientation('landscape');
 	
		return $pdf->stream('Template.pdf');
		
	}



	public function loanlisting(){

		$loans = Loanaccount::all();

		$organization = Organization::find(1);

		$pdf = PDF::loadView('pdf.loanreports.loanbalances', compact('loans', 'organization'))->setPaper('a4')->setOrientation('potrait');
 	
		return $pdf->stream('Loan Listing.pdf');
		
	}



	public function loanproduct($id){

		$loans = Loanproduct::find($id);

		$organization = Organization::find(1);

		$pdf = PDF::loadView('pdf.loanreports.loanproducts', compact('loans', 'organization'))->setPaper('a4')->setOrientation('potrait');
 	
		return $pdf->stream('Loan Product Listing.pdf');
		
	}



	public function savinglisting(){

		$savings = Savingaccount::all();

		$from = Input::get('from');
        $to = Input::get('to');

        $product = Savingproduct::find(Input::get('id'));

			/*$savings = DB::table('savingtransactions')
		        ->join('savingaccounts', 'savingtransactions.savingaccount_id', '=', 'savingaccounts.id')
		        ->join('savingproducts', 'savingaccounts.savingproduct_id', '=', 'savingproducts.id')
		        ->join('members', 'savingaccounts.member_id', '=', 'members.id')
		        ->whereBetween('date', array($from, $to))
		        ->where('void',0)
		        ->select('members.name as name','date','savingproducts.name as pname','membership_no','account_number','savingaccounts.id')
		        ->get();*/
			$members = Member::all();

		$organization = Organization::find(1);

		$pdf = PDF::loadView('pdf.savingreports.savingbalances', compact('savings','from','to','product', 'organization'))->setPaper('a4')->setOrientation('potrait');
 	
		return $pdf->stream('Savings Listing.pdf');
		
	}



	public function savingproduct(){

		$from = Input::get('from');

		$to = Input::get('to');

		$organization = Organization::find(1);

		if(Input::get('mid') == 'all'){
			$product = Savingproduct::find(Input::get('id'));
            $savings = Savingaccount::all();
			/*$savings = DB::table('savingtransactions')
		        ->join('savingaccounts', 'savingtransactions.savingaccount_id', '=', 'savingaccounts.id')
		        ->join('savingproducts', 'savingaccounts.savingproduct_id', '=', 'savingproducts.id')
		        ->join('members', 'savingaccounts.member_id', '=', 'members.id')
		        ->whereBetween('date', array($from, $to))
		        ->where('void',0)
		        ->select('members.name as name','date','savingproducts.name as pname','membership_no','account_number','savingaccounts.id')
		        ->get();*/
			$members = Member::all();
			$pdf = PDF::loadView('pdf.savingreports.savingallproducts', compact('product','savings','members','from','to', 'organization'))->setPaper('a4')->setOrientation('potrait');
 	
		return $pdf->stream('Saving Product Listing.pdf');
		}else{
			$saving = Savingaccount::where('member_id',Input::get('mid'))->first();
			$transactions = Savingtransaction::where('savingaccount_id',$saving->id)->whereBetween('date', array($from, $to))->where('void',0)->orderBy('date','ASC')->get();
			$product = Savingproduct::where('id',$saving->savingproduct_id)->first();
			$member = Member::find(Input::get('mid'));
			$pdf = PDF::loadView('pdf.savingreports.savingproducts', compact('product','saving','transactions','member','from','to', 'organization'))->setPaper('a4')->setOrientation('potrait');
 	
		return $pdf->stream('Saving Product Listing.pdf');
		}

		

		
		
	}

	public function memberstatements(){

		$vehicles = Vehicleincome::where('member_id',Input::get('member_id'))->get();

		$member = Member::find(Input::get('member_id'));

		$organization = Organization::find(1);

		$currency = Currency::find(1);

		$pdf = PDF::loadView('pdf.memberstatements', compact('vehicles', 'organization','member','currency'))->setPaper('a4')->setOrientation('potrait');
 	
		return $pdf->stream('Member Statements.pdf');
		
	}
	


	public function financials(){

		
		$report = Input::get('report_type');
		$date = Input::get('date');

		$accounts = Account::all();

		$organization = Organization::find(1);


		if($report == 'balancesheet'){

			

			$pdf = PDF::loadView('pdf.financials.balancesheet', compact('accounts', 'date', 'organization'))->setPaper('a4')->setOrientation('potrait');
 	
			return $pdf->stream('Balance Sheet.pdf');

		}


		if($report == 'income'){

			$pdf = PDF::loadView('pdf.financials.incomestatement', compact('accounts', 'date', 'organization'))->setPaper('a4')->setOrientation('potrait');
 	
			return $pdf->stream('Income Statement.pdf');

		}


		if($report == 'trialbalance'){

			$pdf = PDF::loadView('pdf.financials.trialbalance', compact('accounts', 'date', 'organization'))->setPaper('a4')->setOrientation('potrait');
 	
			return $pdf->stream('Trial Balance.pdf');

		}



	}



	public function expenseincome(){

		if(Input::get('type') == 'All'){
        if(Input::get('vehicle_id') == 'All'){
		$type = Input::get('type');

        $vehicle_id = Input::get('vehicle_id');

        $from = Input::get('from');

        $to = Input::get('to');

        $vehicleincomes = Vehicleincome::whereBetween('date', array($from, $to))->get();

        $vehicleexpenses = Vehicleexpense::whereBetween('date', array($from, $to))->get();

		$organization = Organization::find(1);

        $currency = Currency::find(1);

		$pdf = PDF::loadView('pdf.vehicleincomestatement', compact('vehicleincomes','vehicleexpenses','type','from','to','currency', 'vehicle_id','organization'))->setPaper('a4')->setOrientation('potrait');
 	
		return $pdf->stream($type.' report.pdf');
		}else{
        $type = Input::get('type');

        $vehicle_id = Input::get('vehicle_id');

        $from = Input::get('from');

        $to = Input::get('to');

        $vehicleincomes = Vehicleincome::whereBetween('date', array($from, $to))->where('vehicle_id',Input::get('vehicle_id'))->get();

        $vehicleexpenses = Vehicleexpense::whereBetween('date', array($from, $to))->where('vehicle_id',Input::get('vehicle_id'))->get();

        $totalincs = Vehicleincome::where('vehicle_id',Input::get('vehicle_id'))->where('vehicle_id',Input::get('vehicle_id'))->whereBetween('date', array($from, $to))->sum('amount');
        
        $totalexps = Vehicleexpense::where('vehicle_id',Input::get('vehicle_id'))->where('vehicle_id',Input::get('vehicle_id'))->whereBetween('date', array($from, $to))->sum('amount');

        $veh = Vehicle::where('id',Input::get('vehicle_id'))->first();

        $vehicle_id = Input::get('vehicle_id');

		$organization = Organization::find(1);

		$currency = Currency::find(1);

		$pdf = PDF::loadView('pdf.vehicleincomestatement', compact('vehicleincomes','vehicleexpenses','totalincs','totalincs','vehicle_id','currency','veh','type','from','to', 'organization'))->setPaper('a4')->setOrientation('potrait');
 	
		return $pdf->stream($type.' report.pdf');
	    }
		}else{

		if(Input::get('vehicle_id') == 'All'){
		$type = Input::get('type');

        $vehicle_id = Input::get('vehicle_id');

        $from = Input::get('from');

        $to = Input::get('to');

        $vehicleincomes = Vehicleincome::whereBetween('date', array($from, $to))->get();

        $vehicleexpenses = Vehicleexpense::whereBetween('date', array($from, $to))->get();

		$organization = Organization::find(1);

        $currency = Currency::find(1);

		$pdf = PDF::loadView('pdf.expenseincome', compact('vehicleincomes','vehicleexpenses','type','from','to','currency', 'vehicle_id','organization'))->setPaper('a4')->setOrientation('potrait');
 	
		return $pdf->stream($type.' report.pdf');
		}else{
        $type = Input::get('type');

        $vehicle_id = Input::get('vehicle_id');

        $from = Input::get('from');

        $to = Input::get('to');

        $vehicleincomes = Vehicleincome::whereBetween('date', array($from, $to))->where('vehicle_id',Input::get('vehicle_id'))->get();

        $vehicleexpenses = Vehicleexpense::whereBetween('date', array($from, $to))->where('vehicle_id',Input::get('vehicle_id'))->get();

        $veh = Vehicle::where('id',Input::get('vehicle_id'))->first();

        $vehicle_id = Input::get('vehicle_id');

		$organization = Organization::find(1);

		$currency = Currency::find(1);

		$pdf = PDF::loadView('pdf.expenseincome', compact('vehicleincomes','vehicleexpenses','vehicle_id','currency','veh','type','from','to', 'organization'))->setPaper('a4')->setOrientation('potrait');
 	
		return $pdf->stream($type.' report.pdf');
	}
		
	}
}

public function payrollmembers(){

		$members = Member::all();

		return View::make('pdf.indmember',compact('members'));
		
	}

	public function payroll(){
		$from = Input::get('from');

        $to = Input::get('to');

        $member = Member::find(Input::get('member_id'));

		$savings = Savingaccount::where('member_id',Input::get('member_id'))->get();

		$loans = Loanaccount::where('member_id',Input::get('member_id'))->get();

		$contributions = Contribution::where('member_id',Input::get('member_id'))->where('is_void',false)->whereBetween('date', array($from, $to))->get();

		$shares = Shareaccount::where('member_id',Input::get('member_id'))->get();

		$tlbs = DB::table('tlbpayments')
		        ->join('vehicles', 'tlbpayments.vehicle_id', '=', 'vehicles.id')
		        ->join('members', 'vehicles.member_id', '=', 'members.id')
		        ->whereBetween('date', array($from, $to))
		        ->where('member_id',Input::get('member_id'))
		        ->get();

		$organization = Organization::find(1);

		$pdf = PDF::loadView('pdf.memberreceipt', compact('savings','tlbs','from','to','loans','contributions','shares', 'organization', 'member'))->setPaper('a6')->setOrientation('potrait');
 	
		return $pdf->stream($member->membership_number.'_'.$member->name.'_payroll_statement.pdf');
		
	}

	public function savingperiod(){
        $members = Member::all();
		return View::make('pdf.savingperiod',compact('members'));
		
	}

	public function savingproductperiod(){
        $savingproducts = Savingproduct::all();
        $members = Member::all();
		return View::make('pdf.savingproductperiod',compact('savingproducts','members'));
		
	}

}
