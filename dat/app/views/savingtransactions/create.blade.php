@extends('layouts.main')
{{ HTML::script('media/jquery-1.12.0.min.js') }}
@section('content')

<script type="text/javascript">
$(document).ready(function(){
  $("#ac").hide();
$('#category').change(function(){
  
if($(this).val() == "vehicle"){
  $("#ac").hide();
  $("#a").show();
  $("#amount").val('0.00');   
    $.get("{{ url('api/getVehicle')}}", 
        { option: $("#member").val() }, 
        function(data) {
            /*console.log('hi');*/
            
                //asANumber = +noCommas;
                //alert(data);
                $('#amount').keyup(function(){
                  var noCommas = this.value.replace(/,/g, "");
                  //alert(noCommas);
                if(data<parseFloat(noCommas)){
                     alert('Amount inputed is more than the income earned from the vehicle!');
                     $("#amount").val('0.00');   
                }
                });
            });
}else{
 $("#ac").show();
 $("#a").hide();
 $("#amountcash").val('0.00');  
}

});
});
</script>
<br/>

<?php


function asMoney($value) {
  return number_format($value, 2);
}

?>

<div class="row">
	<div class="col-lg-12">
  <strong>Member: {{ $member->name }}</strong><br>
  <strong>Member #: {{ $member->membership_no }}</strong><br>
<strong>Savings Account #: {{ $savingaccount->account_number }}</strong><br>
<strong>Account Balance #: {{ asMoney($balance) }}</strong><br>
@if($balance > Savingtransaction::getWithdrawalCharge($savingaccount))
<strong>Available Balance #: {{ asMoney($balance - Savingtransaction::getWithdrawalCharge($savingaccount)) }}</strong><br>
@endif
<hr>
</div>	
</div>


<div class="row">
	<div class="col-lg-4">

    
		
		 @if ($errors->has())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>        
            @endforeach
        </div>
        @endif

		 <form method="POST" action="{{{ URL::to('savingtransactions') }}}" accept-charset="UTF-8">



   
    <fieldset>
        <div class="form-group">
            <label for="username">Transaction </label>
           <select name="type" class="form-control" required>
            <option></option>
            <option value="credit"> Deposit</option>
            <option value="debit"> Withdraw</option>
           </select>
        </div>
        
        
        
         <input type="hidden" name="account_id" value="{{ $savingaccount->id}}">

         <input class="form-control" placeholder="" type="hidden" name="member" id="member" value="{{$member->id}}">
        

        <div class="form-group">
            <label for="username"> Date</label>
            <div class="right-inner-addon ">
            <i class="glyphicon glyphicon-calendar"></i>
            <input class="form-control datepicker" readonly placeholder="" type="text" name="date" id="date" value="{{{ Input::old('date') }}}" required>
        </div>
        </div>


       

        <div class="form-group" id="a">
            <label for="username">Amount</label>
            <input class="form-control" placeholder="" type="text" name="amount" id="amount" value="{{{ Input::old('amount') }}}">
        </div>

        

         <div class="form-group">
            <label for="username"> Description</label>
            <textarea class="form-control" name="description">{{{ Input::old('description') }}}</textarea>
            
        </div>


         <div class="form-group">
            <label for="username"> Transacted by</label>
            <input class="form-control" placeholder="" type="text" name="transacted_by" id="transacted_by" value="{{{ Input::old('transacted_by') }}}" required>
  
        </div>



        
      
        
        <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm">Submit</button>
        </div>

    </fieldset>
</form>
		

  </div>

</div>
























@stop