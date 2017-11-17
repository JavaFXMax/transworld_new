@extends('layouts.member')
{{ HTML::script('media/jquery-1.12.0.min.js') }}
@section('content')

<script type="text/javascript">
$(document).ready(function(){
$("#inc").hide();

$('#type option#exp').each(function() {
    if (this.selected){
       $("#inc").show();
}else{
  $("#inc").hide();
  $("#incur").val('');
}
});

$('#vehicle_id').change(function(){
        $.get("{{ url('api/loanaccount')}}", 
        { option: $(this).val() }, 
        function(data) {
            $('#loanproduct').empty(); 
            $('#loanproduct').append("<option value=''>----------------select Member Loan Product--------------------</option>");
            $.each(data, function(key, element) {
            $('#loanproduct').append("<option value='" + key +"'>" + element + "</option>");
            });
        });
    });


$('#type').change(function(){
if($(this).val() == "Expense"){
  $("#inc").show();
}else{
  $("#inc").hide();
  $("#incur").val('');
}

});

$('#amount').keyup(function(){
var savings = $('#savings').val('0.00');
var shares  = $('#shares').val('0.00');
var offamt  = $('#offamt').val('0.00');
var loans   = $('#loans').val('0.00');
});


$('#shares').keyup(function(){
var amount = $('#amount').val().replace(/,/g, '');
var savings = $('#savings').val().replace(/,/g, '');
var shares = $('#shares').val().replace(/,/g, '');
var loans = $('#loans').val().replace(/,/g, '');
var offamt = $('#offamt').val().replace(/,/g, '');
var balance = 0;
balance = amount - savings - loans - offamt;
if(balance<shares || amount==''){
  alert('The value can`t exceed '+balance);
  shares = $('#shares').val('0.00');
}
});

$('#savings').keyup(function(){
var amount = $('#amount').val().replace(/,/g, '');
var savings = $('#savings').val().replace(/,/g, '');
var shares = $('#shares').val().replace(/,/g, '');
var loans = $('#loans').val().replace(/,/g, '');
var offamt = $('#offamt').val().replace(/,/g, '');
var balance = 0;
balance = amount - shares - loans - offamt;
if(balance<savings || amount==''){
  alert('The value can`t exceed '+balance);
  savings = $('#savings').val('0.00');
}
});

$('#offamt').keyup(function(){
var amount = $('#amount').val().replace(/,/g, '');
var savings = $('#savings').val().replace(/,/g, '');
var shares = $('#shares').val().replace(/,/g, '');
var loans = $('#loans').val().replace(/,/g, '');
var offamt = $('#offamt').val().replace(/,/g, '');
var balance = 0;
balance = amount - shares - loans - savings;
if(balance<offamt || amount==''){
  alert('The value can`t exceed '+balance);
  offamt = $('#offamt').val('0.00');
}
});

$('#loans').keyup(function(){
var amount = $('#amount').val().replace(/,/g, '');
var savings = $('#savings').val().replace(/,/g, '');
var shares = $('#shares').val().replace(/,/g, '');
var loans = $('#loans').val().replace(/,/g, '');
var offamt = $('#offamt').val().replace(/,/g, '');
var balance = 0;
balance = amount - shares - savings - offamt;
if(balance<loans || amount==''){
  alert('The value can`t exceed '+balance);
  loans = $('#loans').val('0.00');
}
});

});
</script>
<br/>

<div class="row">
  <div class="col-lg-12">
  <h3>Edit Vehicle - {{$veh->make.' - '.$veh->regno}}</h3>

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


       

     <form method="POST" action="{{{ URL::to('vehicleincomes/update/'.$vehicle->id) }}}" accept-charset="UTF-8">
   
    <fieldset>

                    <div class="form-group">
                        
                        <input class="form-control" placeholder="" type="hidden" name="vehicle_id" id="vehicle_id" value="{{$vehicle->vehicle_id}}">
                
                    </div>  

      

        
        <div class="form-group">
                        <label for="username">Date <span style="color:red">*</span></label>
                        <div class="right-inner-addon ">
                        <i class="glyphicon glyphicon-calendar"></i>
                        <input required class="form-control datepicker" readonly="readonly" placeholder="" type="text" name="date" id="date" value="{{$vehicle->date}}">
                    </div>
       </div>

          <div class="form-group">
            <label for="username">Amount:</label>
            <input class="form-control" placeholder="" type="text" name="amount" id="amount" value="{{number_format($vehicle->amount,2)}}">
        </div>

        <div class="form-group">
                        <label for="username">Loan Product</label>
                        <select name="loanproduct_id" id="loanproduct" class="form-control">
                            <option value=''></option>
                            @foreach($loanproducts as $loanproduct)
                            <option value="{{ $loanproduct->id }}"<?= ($vehicle->loanaccount_id==$loanproduct->id)?'selected="selected"':''; ?>> {{ $loanproduct->name }}</option>
                            @endforeach
                        </select>
                
                    </div>

        <div class="form-group">
            <label for="username">Loan Repayment</label>
            @if($vehicle->loantransaction_id == null)
            <input required class="form-control" placeholder="" type="text" name="loans" id="loans" value="0.00">
            @else
            <input required class="form-control" placeholder="" type="text" name="loans" id="loans" value="{{number_format($loantransaction->amount,2)}}">
            @endif
        </div>

        

        <div class="form-group">
            <label for="username">Office Contribution
            </label>
            <input required class="form-control" placeholder="" type="text" name="offamt" id="offamt" value="{{number_format($officecontribution->amount,2)}}">
        </div>


        <div class="form-group">
            <label for="username">Commissions/Savings</label>
            @if($vehicle->savingtransaction_id == null)
            <input required class="form-control" placeholder="" type="text" name="savings" id="savings" value="0.00">
            @else
            <input required class="form-control" placeholder="" type="text" name="savings" id="savings" value="{{number_format($savingtransaction->amount,2)}}">
            @endif
        </div>

        <div class="form-group">
            <label for="username">Shares 
            </label>
            @if($vehicle->sharetransaction_id == null)
            <input required class="form-control" placeholder="" type="text" name="shares" id="shares" value="0.00">
            @else
            <input required class="form-control" placeholder="" type="text" name="shares" id="shares" value="{{number_format($sharetransaction->amount,2)}}">
            @endif
        </div>

       <div class="form-group">
            <label for="username">Asset Account <span style="color:red">*</span> </label>
            <select  required class="form-control" name="asset_id" id="account">
            <option> select account</option>
              @foreach($asset as $account)  
                    <option value="{{$account->id}}"<?= ($vehicle->asset_account_id==$account->id)?'selected="selected"':''; ?>>{{$account->name}}</option>
              @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="username">Liability Account <span style="color:red">*</span> </label>
            <select  required class="form-control" name="ainc_id" id="account">
            <option> select account</option>
              @foreach($ainc as $account)  
                    <option value="{{$account->id}}"<?= ($vehicle->income_account_id==$account->id)?'selected="selected"':''; ?>>{{$account->name}}</option>
              @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="username">Equity Account <span style="color:red">*</span> </label>
            <select  required class="form-control" name="eq_id" id="account">
            <option> select account</option>
              @foreach($equities as $account)  
                    <option value="{{$account->id}}"<?= ($vehicle->equity_account_id==$account->id)?'selected="selected"':''; ?>>{{$account->name}}</option>
              @endforeach
            </select>
        </div>

        <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm">Update</button>
        </div>

    </fieldset>
</form>
    

  </div>

</div>




@stop