@extends('layouts.membercss')
@section('content')

<script type="text/javascript">
$(document).ready(function(){
$('#amt').hide();
$('#amtshow').click(function(){
    $('#amt').show();
});
$('#rej').click(function(){
    $('#amt').hide();
    $('#amount').val('');
});
});
</script>


<br/>

<div class="row">
	<div class="col-lg-12">
  <h3>{{$loanaccount->loanproduct->name}} for {{$loanaccount->member->name}}</h3>

<hr>
</div>	
</div>


<div class="row">
	<div class="col-lg-7">

      <table class="table table-bordered table-condensed table-hover table-stripped">
          <tr>
            <td>Member Name</td><td>{{$loanaccount->member->name}}</td>

          </tr>

          <tr>
            <td>Loan Product Name</td><td>{{$loanaccount->loanproduct->name}}</td>

          </tr>
          <tr>
            <td>Date Applied</td><td>{{$loanaccount->application_date}}</td>

          </tr>
          <tr>
            <td>Amount</td><td>{{number_format($loanaccount->amount_applied,2)}}</td>

          </tr>
          <tr>
            <td>Interest Rate</td><td>{{$loanaccount->interest_rate}} % monthly</td>

          </tr>
          <tr>
            <td>Period</td><td>{{$loanaccount->period}} Months</td>

          </tr>
         
      </table>

     <div align="right"> 
     
                 <form id="form" method="POST" action="{{{ URL::to('gurantorreject/'.$loanaccount->id) }}}" accept-charset="UTF-8" enctype="multipart/form-data">
                  <input class="form-control" style="width:200px" placeholder="" type="hidden" name="mid1" id="mid" value="{{$loanaccount->member->id}}">
                  <input class="form-control" style="width:200px" placeholder="" type="hidden" name="amount_applied1" id="amount_applied" value="{{$loanaccount->amount_applied}}">
                  <input class="form-control" style="width:200px" placeholder="" type="hidden" name="pname1" id="pname" value="{{$loanaccount->loanproduct->name}}">
                   <a href="#" id="amtshow"><button type="button" class="btn btn-success btn-sm">
                    Approve 
                  </button></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a id="rej" href="" onclick="return (confirm('Are you sure you want to reject this loan application?'))"><button type="submit" class="btn btn-danger btn-sm">
                    Reject 
                  </button></a><br><br>
                 </form>
                  <form id="form" method="POST" action="{{{ URL::to('gurantorapprove/'.$loanaccount->id) }}}" accept-charset="UTF-8" enctype="multipart/form-data">
                  <div id="amt">
                  <input class="form-control" style="width:200px" placeholder="" type="hidden" name="mid" id="mid" value="{{$loanaccount->member->id}}">
                  <input class="form-control" style="width:200px" placeholder="" type="hidden" name="amount_applied" id="amount_applied" value="{{$loanaccount->amount_applied}}">
                  <input class="form-control" style="width:200px" placeholder="" type="hidden" name="pname" id="pname" value="{{$loanaccount->loanproduct->name}}">
                  <label for="username">Guarantor Amount</label>
                  <input class="form-control" style="width:200px" placeholder="" type="text" name="amount" id="amount" value="{{{ Input::old('amount') }}}">
                  <br/>
                  <div class="col-lg-4 pull-right">
                  <fieldset>
                        <div class="form-actions form-group">
                            <button type="submit" id="kindetails" class="btn btn-primary btn-sm">Accept</button>
                        </div>
                </fieldset>
                </div>
                </div>
                </form>
                </div>
       

  </div>
</div>




@stop