@extends('layouts.member')
{{ HTML::script('media/jquery-1.12.0.min.js') }}
@section('content')
<br/>
<?php
function asMoney($value) {
  return number_format($value, 2);
}
?>
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
       <table class="table table-condensed table-bordered">
        <tr>
          <td>Member</td><td>{{$loanaccount->member->name}}</td>
        </tr>
        <tr>
          <td>Loan Account</td><td>{{$loanaccount->account_number}}</td>
        </tr>
        <tr>
          <td>Loan Amount</td><td>{{ asMoney($loanaccount->amount_disbursed + $interest) }}</td>
        </tr>
        <tr>
          <td>Loan Balance</td><td>{{ asMoney($loanbalance) }}</td>
        </tr>
       </table>
		 <form method="POST" action="{{{ URL::to('loanrepayments') }}}" accept-charset="UTF-8">
    <fieldset>
       <table class="table table-condensed table-bordered">
        <tr>
          <td>Principal Due</td><td>{{ asMoney($principal_due) }}</td>
        </tr>
        <tr>
          <td>Interest Due</td><td>{{ asMoney($interest_due) }}</td>
        </tr>
        <tr>
          <td>Amount Due</td><td>{{ asMoney($principal_due + $interest_due)}}</td>
        </tr>
        </table>
        <input class="form-control" placeholder="" type="hidden" name="loanaccount_id" id="loanaccount_id" value="{{ $loanaccount->id }}">
         <input class="form-control" placeholder="" type="hidden" name="member" id="member" value="{{$loanaccount->member->id}}">
         <input type="hidden" name="amount_supposed_to_pay" value="{{$principal_due + $interest_due}}"/>
         <div class="form-group">
                <label for="username">Repayment Date <span style="color:red">*</span></label>
                <div class="right-inner-addon ">
                    <i class="glyphicon glyphicon-calendar"></i>
                    <input required class="form-control datepicker" readonly="readonly" placeholder="" type="text" name="date" id="date"
                    value="{{{ Input::old('date') }}}">
            </div>
       </div>
        <div class="form-group" id="a">
            <label for="username">Amount</label>
            <input class="form-control" placeholder="" type="text" name="amount" id="amount" value="{{{ Input::old('amount') }}}">
        </div>
        <div class="form-actions form-group">
          <button type="submit" class="btn btn-primary btn-sm">Submit Payment</button>
        </div>
    </fieldset>
</form>
  </div>
</div>
@stop
