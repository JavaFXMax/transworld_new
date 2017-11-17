@extends('layouts.member')
@section('content')
<br/>

<div class="row">
    <div class="col-lg-12">
  <h3>Edit Member Fee</h3>

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

         <form method="POST" action="{{{ URL::to('membersfee/update/'.$membersfee->id) }}}" accept-charset="UTF-8">
   
    <fieldset>
        <div class="form-group">
                        <label for="username">Member registration Fee</label>
                        <input class="form-control" placeholder="" type="text" name="member_registration_fee" id="member_registration_fee" value="{{$membersfee->member_registration_fee}}">
                    </div>

            <div class="form-group">
            <label for="username">Equity Account <span style="color:red">*</span> </label>
            <select  required class="form-control" name="eq_id" id="account">
            <option> select account</option>
              @foreach($equities as $account)  
                    <option value="{{$account->id}}"<?= ($membersfee->account_id==$account->id)?'selected="selected"':''; ?>>{{$account->name}}</option>
              @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label for="username">Asset Account <span style="color:red">*</span> </label>
            <select  required class="form-control" name="asset_id" id="account">
            <option> select account</option>
              @foreach($asset as $account)  
                    <option value="{{$account->id}}"<?= ($membersfee->asset_id==$account->id)?'selected="selected"':''; ?>>{{$account->name}}</option>
              @endforeach
            </select>
        </div>

        <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm">Update Member Fee</button>
        </div>

    </fieldset>
</form>
        

  </div>

</div>


@stop