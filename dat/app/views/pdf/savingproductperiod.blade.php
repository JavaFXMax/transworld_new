@extends('layouts.ports')

@section('content')
<br/>

<div class="row">
	<div class="col-lg-12">
  <h3>Period</h3>

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

		 <form method="POST" target="blank" action="{{{ URL::to('reports/savingproduct') }}}" accept-charset="UTF-8">
   
    <fieldset>

        <div class="form-group">
            <label for="username">Saving Product</label>
            <select class="form-control" name="id" id="id" required>
                <option value="">select product</option>
                <option>--------------------------</option>
                @foreach($savingproducts as $savingproduct)
                <option value="{{$savingproduct->id}}">{{ $savingproduct->name }}</option>
                @endforeach
            </select>
            
        </div>

        <div class="form-group">
            <label for="username">Member</label>
            <select class="form-control" name="mid" id="mid" required>
                <option value="">select member</option>
                <option>--------------------------</option>
                <option value="all">All</option>
                @foreach($members as $member)
                <option value="{{$member->id}}">{{ $member->name }}</option>
                @endforeach
            </select>
            
        </div>


        <div class="form-group">
                        <label for="username">From <span style="color:red">*</span></label>
                        <div class="right-inner-addon ">
                        <i class="glyphicon glyphicon-calendar"></i>
                        <input required class="form-control datepicker" readonly="readonly" placeholder="" type="text" name="from" id="from" value="{{{ Input::old('from') }}}">
                    </div>
       </div>


       <div class="form-group">
                        <label for="username">To <span style="color:red">*</span></label>
                        <div class="right-inner-addon ">
                        <i class="glyphicon glyphicon-calendar"></i>
                        <input required class="form-control datepicker" readonly="readonly" placeholder="" type="text" name="to" id="to" value="{{{ Input::old('to') }}}">
                    </div>
       </div>


        <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm">Select</button>
        </div>

    </fieldset>
</form>
		

  </div>

</div>
























@stop