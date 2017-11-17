@extends('layouts.member')
{{ HTML::script('media/jquery-1.12.0.min.js') }}
@section('content')


<br/>

<div class="row">
	<div class="col-lg-12">
  <h3>Vehicle Incomes</h3>

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


       

		 <form method="POST" action="{{{ URL::to('vehicleexpenses') }}}" accept-charset="UTF-8">
   
    <fieldset>  

                    <div class="form-group">
                        <label for="username">Vehicle <span style="color:red">*</span></label>
                        <select name="vehicle_id" class="form-control" data-live-search="true" required>
                           <option></option>
                            @foreach($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}"> {{ $vehicle->make.' - '.$vehicle->regno }}</option>
                            @endforeach
                        </select>
                
                    </div>  


        <div class="form-group" id="inc">
            <label for="username">Expense Incurred:</label>
            <input class="form-control" placeholder="" type="text" name="incur" id="incur" value="{{{ Input::old('incur') }}}">
        </div>

        <div class="form-group">
                        <label for="username">Date <span style="color:red">*</span></label>
                        <div class="right-inner-addon ">
                        <i class="glyphicon glyphicon-calendar"></i>
                        <input required class="form-control datepicker" readonly="readonly" placeholder="" type="text" name="date" id="date" value="{{{ Input::old('date') }}}">
                    </div>
       </div>

        <div class="form-group">
            <label for="username">Amount <span style="color:red">*</span></label>
            <input required class="form-control" placeholder="" type="text" name="amount" id="amount" value="{{{ Input::old('amount') }}}">
        </div>

        <div class="form-group">
            <label for="username">Asset Account <span style="color:red">*</span> </label>
            <select  required class="form-control" name="asset_id" id="account">
            <option> select account</option>
              @foreach($asset as $account)  
                    <option value="{{$account->id}}">{{$account->name}}</option>
              @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="username">Expense Account <span style="color:red">*</span> </label>
            <select  required class="form-control" name="aexp_id" id="account">
            <option> select account</option>
              @foreach($aexp as $account)  
                    <option value="{{$account->id}}">{{$account->name}}</option>
              @endforeach
            </select>
        </div>

        <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm">Create Expense</button>
        </div>

    </fieldset>
  </form>
		

  </div>

</div>


@stop