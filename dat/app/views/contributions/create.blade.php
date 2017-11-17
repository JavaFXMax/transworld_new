@extends('layouts.main')
@section('content')
<br/>

<div class="row">
	<div class="col-lg-12">
  <strong>Member: {{ $member->name }}</strong><br>
  <strong>Member #: {{ $member->membership_no }}</strong><br>

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

		 <form method="POST" action="{{{ URL::to('contributions') }}}" accept-charset="UTF-8">



   
    <fieldset>
        <div class="form-group">
            <label for="username">Transaction Type </label>
           <select name="type" class="form-control" required>
            <option></option>
            <option value="debit"> Debit</option>
            <option value="credit"> Credit (missed contribution)</option>
           
           </select>
        </div>
        
        
        
         <input type="hidden" name="member_id" value="{{ $member->id}}">
        

        <div class="form-group">
            <label for="username"> Date</label>
            <div class="right-inner-addon ">
            <i class="glyphicon glyphicon-calendar"></i>
            <input class="form-control datepicker" placeholder="" readonly type="text" name="date" id="date" value="{{{ Input::old('date') }}}" required>
        </div>
        </div>


        <div class="form-group">
            <label for="username"> Amount</label>
            <input class="form-control" placeholder="" type="text" name="amount" id="amount" value="{{{ Input::old('amount') }}}" required>
        </div>


        <div class="form-group">
            <label for="username">Missed Contribution Reasons</label>
            <textarea name="reasons" class="form-control"></textarea>
        </div>


        
         <div class="form-group">
            <label for="username">Asset Account <span style="color:red">*</span> </label>
            <select  required class="form-control" name="debit_account" id="account">
            <option> select account</option>
              @foreach($assets as $account)  
                    <option value="{{$account->id}}">{{$account->name}}</option>
              @endforeach
            </select>
        </div>

        

        <div class="form-group">
            <label for="username">Equity Account <span style="color:red">*</span> </label>
            <select  required class="form-control" name="credit_account" id="account">
            <option> select account</option>
              @foreach($equities as $account)  
                    <option value="{{$account->id}}">{{$account->name}}</option>
              @endforeach
            </select>
        </div>




        
      
        
        <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm">Submit</button>
        </div>

    </fieldset>
</form>
		

  </div>

</div>
























@stop