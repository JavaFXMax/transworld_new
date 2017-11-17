@extends('layouts.main')
@section('content')

<br><br>
		
										<div class="row">
											<div class="col-md-4">

												<form method="post" action="{{URL::to('transaudits')}}">
													<input type="date" class="form-control datepicker" placeholder="Transaction date" name="date" id="date" readonly>

													
												
												
											</div>


											<div class="col-md-4">

												<select name="type" class="form-control" required>
												
														<option value="loan">Loan Transactions</option>
														<option value="savings">Savings Transactions</option>
												</select>
													
												
												
											</div>

											<div class="col-md-4">

												
													

													<button class="btn btn-primary">View Transactions</button>
												</form>
												
											</div>

											
											

											


											
											
										</div>
									



<div class="row">
	
	<div class="col-lg-12">
		<hr>

	</div>
</div>


<div class="row">
	


	<div class="col-lg-12">

@if(Session::get('notice'))
            <div class="alert">{{{ Session::get('notice') }}}</div>
        @endif
	<div class="panel panel-success">
      <div class="panel-heading">
          <h4>{{ ucwords($type) }} Transactions - {{ date('d-M-Y', strtotime($date))}}</h4>
        </div>
        <div class="panel-body">

		  <table id="users" class="table table-condensed table-bordered table-responsive table-hover">


      <thead>

        <th>#</th>
        <th>Member</th>
        <th>Account</th>
        <th>Description</th>

        <th>Amount</th>
        

      </thead>
      <tbody>

      <?php $i =1; ?>
      @foreach($transactions as $transaction)
        
        <tr>

        	<td>{{$i}}</td>
        	<td>

        	@if($type == 'loan')
        	{{Loantransaction::getMember($transaction->loanaccount_id)}}
        	@endif

        	@if($type == 'savings')
        	{{Savingtransaction::getMember($transaction->savingaccount_id)}}
        	@endif

        	</td>

        	<td>
        	@if($type == 'loan')
        	{{Loantransaction::getLoanaccount($transaction->loanaccount_id)}}
        	@endif

        	@if($type == 'savings')
        	{{Savingransaction::getsavingaccount($transaction->savingaccount_id)}}
        	@endif

        	</td>

        	<td>{{$transaction->description}}</td>
        	<td>{{$transaction->amount}}</td>
        </tr>

      <?php $i++; ?>
      @endforeach

      </tbody>


    </table>
</div>
</div>

	</div>	


<div class="row">

	<div class="col-lg-12">
		<hr>
	</div>	

	

	
</div>
@stop