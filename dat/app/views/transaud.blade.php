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






@stop