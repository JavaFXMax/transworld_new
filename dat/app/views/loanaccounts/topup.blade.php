@extends('layouts.accounting')
@section('content')
<style type="text/css">
    @media screen and (min-width: 768px) {
        .modal-dialog {
          width: 800px; /* New width for default modal */
        }
        .modal-sm {
          width: 400px; /* New width for small modal */
        }
    }
    @media screen and (min-width: 992px) {
        .modal-lg {
          width: 950px; /* New width for large modal */
        }
    }
</style>
<br/>
<div class="row">
    @if (Session::has('caution'))
      <div class="alert alert-warning">
      {{ Session::get('caution') }}
     </div>
    @endif
	<div class="col-lg-3">
    <h3>Loan Top Up</h3> 
  </div>
  <div class="col-lg-3" style="margin-top: 2%;">
     @if($loanaccount->is_top_up==1)
    <button  data-toggle="modal" data-target="#topups" class="btn btn-warning">
      View Topups
    </button>
    @endif
  </div>
</div>
<hr>
<div class="row">
	<div class="col-lg-5">
		 @if ($errors->has())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>        
            @endforeach
        </div>
        @endif
		 <form method="POST" action="{{{ URL::to('loanaccounts/topup/'.$loanaccount->id) }}}" accept-charset="UTF-8">
            <fieldset>
                <?php $date = date('Y-m-d'); ?>
                <input type="hidden" name="loanaccount" value="{{$loanaccount->id}}"/>
                <div class="form-group">
                    <label for="username">Top up Date </label>
                  <input class="form-control" placeholder="" type="date" name="top_up_date" id="application_date" value="{{$date}}">
                </div>
                <div class="form-group">
                    <label for="username">Top Up Amount</label>
                    <input class="form-control" placeholder="" type="text" name="amount" id="amount_applied" value="{{{ Input::old('to_up_amount') }}}">
                </div>
                <div class="form-actions form-group">
                  <button type="submit" class="btn btn-primary btn-sm">Submit</button> 
                </div>
            </fieldset>
        </form>
  </div>
</div>
<?php
function asMoney($value) {
  return number_format($value, 2);
}
?>
@stop