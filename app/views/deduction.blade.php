@extends('layouts.ports')
@section('content')

<br><br>
		
										<div class="row">
											<div class="col-md-4">

												<form method="post" action="{{URL::to('deductions')}}">
													<input type="date" class="form-control datepicker2" placeholder="Deduction Period" name="date" id="date" readonly>

													
												
												
											</div>


											

											<div class="col-md-4">

												
													

													<button class="btn btn-primary">View Deductions</button>
												</form>
												
											</div>

											
											

											


											
											
										</div>
									



<div class="row">
	
	<div class="col-lg-12">
		<hr>

	</div>
</div>






@stop