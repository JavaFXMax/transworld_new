@extends('layouts.member')
{{ HTML::script('media/jquery-1.12.0.min.js') }}
@section('content')


<br/>

<div class="row">
  <div class="col-lg-12">
  <h3>Assign Vehicles</h3>

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


       

     <form method="POST" action="{{{ URL::to('vehicleexpenses/update/'.$vehicle->id) }}}" accept-charset="UTF-8">
   
    <fieldset>

                    <div class="form-group">
                        <label for="username">Vehicle <span style="color:red">*</span></label>
                        <select required name="vehicle_id" class="form-control" data-live-search="true">
                           <option></option>
                            @foreach($vehs as $veh)
                            <option value="{{ $veh->id }}"<?= ($vehicle->vehicle_id==$veh->id)?'selected="selected"':''; ?>> {{ $veh->make.' - '.$veh->regno }}</option>
                            @endforeach
                        </select>
                
                    </div>  

       
        <div class="form-group" id="inc">
            <label for="username">Expense Incurred:</label>
            <input required class="form-control" placeholder="" type="text" name="incur" id="incur" value="{{$vehicle->expenseincurred}}">
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
            <input required class="form-control" placeholder="" type="text" name="amount" id="amount" value="{{number_format($vehicle->amount,2)}}">
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
            <label for="username">Expense Account <span style="color:red">*</span> </label>
            <select  required class="form-control" name="aexp_id" id="account">
            <option> select account</option>
              @foreach($aexp as $account)  
                    <option value="{{$account->id}}"<?= ($vehicle->expense_account_id==$account->id)?'selected="selected"':''; ?>>{{$account->name}}</option>
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