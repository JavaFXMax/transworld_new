@extends('layouts.member')
@section('content')
<br/>
<div class="row">
	<div class="col-lg-12">
      <h3>Create Vehicles</h3>
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
		 <form method="POST" action="{{{ URL::to('vehicles/add') }}}" accept-charset="UTF-8">
            <fieldset>
               <input type="hidden" name="member" value="{{$member->id}}" />
               <div class="form-group">
                    <label for="username">Vehicle Make:</label>
                    <input class="form-control" placeholder="" type="text" name="make" id="make" value="{{{ Input::old('make') }}}">
                </div>
                <div class="form-group">
                    <label for="username">Vehicle Registration Number:</label>
                    <input class="form-control" placeholder="" type="text" name="regno" id="regno" value="{{{ Input::old('regno') }}}">
                </div>
                <div class="form-group">
                    <select class="form-control"  name="registration">
                      @foreach($charges as $charge)
                      <option value="{{$charge->amount}}">{{$charge->name. '-'.$charge->amount}}</option>
                      @endforeach
                    </select>
                </div>
                <div class="form-actions form-group">
                  <button type="submit" class="btn btn-primary btn-sm">Create Vehicle</button>
                </div>
            </fieldset>
        </form>
  </div>
</div>
@stop