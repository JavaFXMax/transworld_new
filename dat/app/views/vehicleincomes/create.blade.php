@extends('layouts.member')
{{ HTML::script('media/jquery-1.12.0.min.js') }}
@section('content')
<script type="text/javascript">
$(document).ready(function() {
    var max_fields      = 9; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID

    var selectwrapper        = $(".select_fields_wrap"); //Fields wrapper
    var select_add_button      = $(".select_add_field_button"); //Add button ID

    var purposewrapper         = $(".purpose_fields_wrap"); //Fields wrapper
    var purpose_add_button      = $(".add_purpose_button"); //Add button ID

    var z = 0; //initial count
    $(purpose_add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(z < max_fields){ //maximum inputs
            z++; //incrementing
            $(purposewrapper).append('<div style="margin-top:10px;margin-left:-15px;"><div class="col-lg-10 form-group"><input class="form-control" placeholder="payment name" name="payment_names[]" style="margin-bottom:10px;margin-right"><input class="form-control" placeholder="amount" type="text" name="amount[]" id="amount"></div><a style="margin-top:70px;margin-left:-20px" href="#" class="col-lg-1 remove_purpose_field">Remove</a></div>'); //add input box
        }
    });

    $(purposewrapper).on("click",".remove_purpose_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); z--;
    });

});
</script>
<script type="text/javascript">
$(document).ready(function(){
$("#inc").hide();
$('#type').change(function(){
if($(this).val() == "Expense"){
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

$('#vehicle_id').change(function(){
    $.get("{{ url('api/membership_status')}}",
    { option: $(this).val() },
    function(data) {
        $("#fee_amount").val('');
        $("#fee_amount").removeAttr('disabled');
        if( data === 'paid'){
            $("#fee_amount").val('PAID');
            $("#fee_amount").attr('disabled','disabled');
        }
    });
});

$('#vehicle_id').change(function(){
    $.get("{{ url('api/share_status')}}",
    { option: $(this).val() },
    function(data) {
        $("#shares").val('');
        $("#shares").removeAttr('disabled');
        if(data==='paid'){
            $("#shares").val('PAID');
            $("#shares").attr('disabled','disabled');
        }
    });
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
      <h3>Vehicle Incomes</h3>
      <hr>
    </div>
</div>
<div class="row">
	<div class="col-lg-10">
		 @if ($errors->has())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
        @endif
		 <form method="POST" action="{{{ URL::to('vehicleincomes') }}}" accept-charset="UTF-8">
    <fieldset>
        <div class="form-group col-md-6">
            <label for="username">Vehicle <span style="color:red">*</span></label>
            <select name="vehicle_id" id="vehicle_id" class="form-control" data-live-search="true" required>
               <option></option>
                @foreach($vehicles as $vehicle)
                <option value="{{ $vehicle->id }}">
                    {{ $vehicle->make.' - '.$vehicle->regno }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="username">Date <span style="color:red">*</span></label>
            <div class="right-inner-addon ">
            <i class="glyphicon glyphicon-calendar"></i>
            <input required class="form-control datepicker" readonly="readonly" placeholder="" type="text" name="date" id="date" value="{{{ Input::old('date') }}}">
        </div>
       </div>
       <div class="form-group col-md-6">
            <label for="username" class="fee_amount">Membership Fee
                <span style="color:red">*</span>
            </label>
            <input class="form-control fee_amount" placeholder="" type="text" name="fee_amount"  hidden="hidden" value="{{{ Input::old('fee_amount') }}}" id="fee_amount">
        </div>
        <div class="form-group col-md-6">
            <label for="username">Loan Product</label>
            <select name="loanproduct_id" id="loanproduct" class="form-control">
                <option value=''></option>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="username">Loan Repayment</label>
            <input required class="form-control" placeholder="" type="text" name="loans" id="loans" value="{{{ Input::old('loans') }}}">
        </div>
        <div class="form-group col-md-6">
            <label for="username">Daily Contribution
            </label>
            <input required class="form-control" placeholder="" type="text" name="offamt" id="offamt" value="{{{ Input::old('offamt') }}}">
        </div>
        <div class="form-group col-md-6">
            <label for="username">
              Insurance
            </label>
            <input required class="form-control" placeholder="" type="text" name="insurance" id="offamt" value="{{{ Input::old('insurance') }}}">
        </div>
        <div class="form-group col-md-6">
            <label for="username">
              Petrol Station Investment
                <span style="color:red">*</span>
            </label>
            <input required class="form-control" type="text" name="petrol_investment" id="offamt" value="{{{ Input::old('petrol_investment') }}}">
        </div>
        <div class="form-group col-md-6">
            <label for="username">Deposits</label>
            <input required class="form-control" placeholder="" type="text" name="savings" id="savings" value="{{{ Input::old('savings') }}}">
        </div>
        <div class="form-group col-md-6">
            <label for="username">
              Shares
            </label>
            <input required class="form-control" placeholder="" type="text" name="shares" id="shares" value="{{{ Input::old('shares') }}}">
        </div>
        <!--Additional Payments For -->
        <div class="purpose_fields_wrap form-group col-lg-8" >
            <button class="btn btn-info add_purpose_button">Add Additional Payments</button>
        </div>
        <!-- Additional Payments For-->
        <div class="form-group col-md-6">
            <label for="username">Asset Account <span style="color:red">*</span> </label>
            <select  required class="form-control" name="asset_id" id="account">
            <option> select account</option>
              @foreach($asset as $account)
                    <option value="{{$account->id}}">{{$account->name}}</option>
              @endforeach
            </select>
        </div>

        <div class="form-group col-md-6">
            <label for="username">Liability Account <span style="color:red">*</span> </label>
            <select  required class="form-control" name="ainc_id" id="account">
            <option> select account</option>
              @foreach($ainc as $account)
                    <option value="{{$account->id}}">{{$account->name}}</option>
              @endforeach
            </select>
        </div>

        <div class="form-group col-md-6">
            <label for="username">Equity Account <span style="color:red">*</span> </label>
            <select  required class="form-control" name="eq_id" id="account">
            <option> select account</option>
              @foreach($equities as $account)
                    <option value="{{$account->id}}">{{$account->name}}</option>
              @endforeach
            </select>
        </div>

        <div class="form-group col-md-12">
          <button type="submit" class="btn btn-primary btn-sm">Create Income</button>
        </div>

    </fieldset>
  </form>
  </div>
</div>
@stop
