@extends('layouts.accounting')
@section('content')
<br/>

<div class="row">
	<div class="col-lg-12">
  <h3>Loan Application</h3>

<hr>
</div>	
</div>


<div class="row">
	<div class="col-lg-5">

    
		
		 @if ($errors->has())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>        
            @endforeach
        </div>
        @endif

<table class="table table-bordered table-condensed">

  <tr>
    <td>Amount Applied</td> <td>{{ $loanaccount->amount_applied}}</td>
  </tr>
  <tr>
    <td>Period Applied</td> <td>{{ $loanaccount->period.' months'}}</td>
    </tr>
  <tr>
    <td>Interest Rate </td> <td>{{ $loanaccount->interest_rate.' %'}}</td>

  </tr>

</table>
       

		 <form method="POST" action="{{{ URL::to('rejectapplication') }}}" accept-charset="UTF-8">
   
    <fieldset>

      <input class="form-control" placeholder="" type="hidden" name="loanaccount_id" id="loanaccount_id" value="{{ $loanaccount->id }}">
         
        <input class="form-control" placeholder="" type="hidden" name="loanproduct_id" id="loanproduct_id" value="{{ $loanaccount->loanproduct->id }}">

          



        <div class="form-group">
            <label for="username">Rejection Reasons</label>
            <textarea name="reasons" class="form-control"></textarea>
        </div>

        
        


        
      
        
        <div class="form-actions form-group">
        
        

          <button type="submit" class="btn btn-primary btn-sm">Submit Rejection</button> 
        </div>

    </fieldset>
</form>

  
  </div>

</div>





















@stop