@extends('layouts.main')
@section('content')
<br/>
<div class="row">
	<div class="col-lg-12">
  <strong>Member: {{ $member->name }}</strong><br>
  <strong>Member #: {{ $member->membership_no }}</strong><br>
<strong>Share Account #: {{ $shareaccount->account_number }}</strong><br>
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
        <?php
            $member= Member::where('id','=',$shareaccount->member_id)->get()->first();
            $share_limit=Member::checkContribution($member->id, 'shares');
            $membership_limit=Member::checkContribution($member->id, 'membership');
        ?>
		 <form method="POST" action="{{{ URL::to('sharetransactions') }}}" accept-charset="UTF-8">
            <fieldset>
                <div class="form-group">
                    <label for="username">Transaction </label>
                   <select name="type" class="form-control" required>
                       <option></option>
                       <option value="credit">Deposit</option>
                   </select>
                </div>
                <input type="hidden" name="account_id" value="{{ $shareaccount->id}}">
                <div class="form-group">
                    <label for="username"> Date</label>
                    <div class="right-inner-addon ">
                        <i class="glyphicon glyphicon-calendar"></i>
                        <input class="form-control datepicker" placeholder="" readonly type="text" name="date" id="date" value="{{{ Input::old('date') }}}" required>
                    </div>
                </div>
                @if($membership_limit != 'paid')
                <div class="form-group">
                    <label for="username">Membership Fee</label>
                    <input class="form-control" type="text" name="fee_amount"
                           value="{{Input::old('fee_amount')}}">
                </div>
                @else
                <div class="form-group">
                    <label for="username">Membership Fee</label>
                    <input class="form-control" type="text" name="fee_amount"
                           value="PAID" disabled>
                </div>
                @endif
                @if($share_limit !='paid')
                <div class="form-group">
                    <label for="username"> Shares</label>
                    <input class="form-control" placeholder="" type="text" name="amount" id="amount" value="{{{ Input::old('amount') }}}" required>
                </div>
                @else
                <div class="form-group">
                    <label for="username"> Shares</label>
                    <input class="form-control" placeholder="" type="text" name="amount" id="amount" value="PAID" disabled>
                </div>
                @endif
				        <div class="form-group">
				            <label for="username">Petrol Station Investment
				                <span style="color:red">*</span>
				            </label>
				            <input required class="form-control" type="text" name="petrol_investment"  value="{{{ Input::old('petrol_investment') }}}">
				        </div>
                <div class="form-group">
                    <label for="username"> Description</label>
                    <textarea class="form-control" name="description">{{{ Input::old('description') }}}</textarea>
                </div>
                <div class="form-actions form-group">
                  <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                </div>
            </fieldset>
        </form>
  </div>
</div>

@stop
