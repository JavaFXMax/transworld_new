@extends('layouts.ports')
@section('content')

<?php


function asMoney($value) {
  return number_format($value, 2);
}

?>

<br><br>
		
										<div class="row">
											<div class="col-md-4">

												<form method="post" action="{{URL::to('deductions')}}">
													<input type="text" class="form-control datepicker2" placeholder="Deduction Period" name="date" id="date">

													
												
												
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


<div class="row">
	
	<div class="col-lg-12">
		
<h4>Deduction Report for : {{$date}}</h4>
<hr>
		<table class="table table-condensed table-bordered">

			<thead>
				<th>Members</th>
				<th>Member #</th>
				@foreach($savingproducts as $savingproduct)
				<th>{{$savingproduct->name}}</th>
				@endforeach

				@foreach($loanproducts as $loanproduct)
				<th>{{$loanproduct->name}}</th>
				@endforeach

				<th>Totals</th>
			</thead>

			<tbody>


			<?php $sumtotal = 0; 

			?>
				
				@foreach($members as $member)

				<?php $total = 0; $prodtotal = 0; 

			?>
				<tr>
					<td>{{$member->name}}</td>
					<td>{{$member->membership_no}}</td>

					@foreach($savingproducts as $savingproduct)
						<td>
							
							@foreach($member->savingaccounts as $savingaccount)

        @if($savingaccount->savingproduct->id == $savingproduct->id)

        <?php $total = $total + Savingaccount::getDeductionAmount($savingaccount, $date); 
          
        ?>
         
        {{asMoney(Savingaccount::getDeductionAmount($savingaccount, $date) ) }}
        @endif

       

        @endforeach
						</td>
					@endforeach

					@foreach($loanproducts as $loanproduct)
						<td>
							
							@foreach($member->loanaccounts as $loanaccount)

        @if($loanaccount->loanproduct->name == $loanproduct->name)

        @if(Loantransaction::getLoanBalance($loanaccount) > 10)

        <?php $total = $total + Loanaccount::getDeductionAmount($loanaccount, $date); 
          
        ?>
         
        {{asMoney(Loanaccount::getDeductionAmount($loanaccount, $date) ) }}

        @endif
        @endif

       

        @endforeach
						</td>
					@endforeach

					<td>{{asMoney($total)}}</td>
<?php $sumtotal = $sumtotal + $total; ?>
				</tr>
				@endforeach


				<tr>
				<td></td>
				<td>Totals</td>
				@foreach($savingproducts as $savingproduct)
				<td></td>
				@endforeach
				@foreach($loanproducts as $loanproduct)
				<td></td>
				@endforeach
				<td>{{asMoney($sumtotal)}}</td>
				</tr>
			</tbody>
			
		</table>





	</div>
</div>






@stop
