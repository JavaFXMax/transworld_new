@extends('layouts.member')
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


       

		 <form method="POST" action="{{{ URL::to('assignvehicles') }}}" accept-charset="UTF-8">
   
    <fieldset>

       <div class="form-group">
                        <label for="username">Member <span style="color:red">*</span></label>
                        <select name="member_id" class="form-control" data-live-search="true">
                           <option></option>
                            @foreach($members as $member)
                            <option value="{{ $member->id }}"> {{ $member->name }}</option>
                            @endforeach
                        </select>
                
                    </div>    

                    <div class="form-group">
                        <label for="username">Vehicle <span style="color:red">*</span></label>
                        <select name="vehicle_id" class="form-control" data-live-search="true">
                           <option></option>
                            @foreach($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}"> {{ $vehicle->make.' - '.$vehicle->regno }}</option>
                            @endforeach
                        </select>
                
                    </div>    

        <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm">Assign Vehicle</button>
        </div>

    </fieldset>
</form>
		

  </div>

</div>
























@stop