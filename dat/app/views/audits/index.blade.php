@extends('layouts.system')
@section('content')
<br/><br/>

<div class="row">
	<div class="col-lg-1">



</div>	

<div class="col-lg-12">

	@if (Session::get('error'))
            <div class="alert alert-danger">{{{ Session::get('error') }}}</div>
        @endif

<p>Audit Trail</p>
<hr>

<br>
</div>	


<div class="col-lg-12 ">

	
<table class="table table-bordered table-responsive table-hover" id="users">

    <thead>
            <th>Date</th>
            <th>Made by</th>
            <th>Entity</th>
            <th>Action</th>
            <th>Amount</th>
    </thead>

    <tbody>
@foreach($audits as $audit)
        <tr>
            <td>{{$audit->created_at}}</td>
            <td>{{$audit->user}}</td>
            <td>{{$audit->entity}}</td>
            <td>{{$audit->action}}</td>
            <td>{{$audit->amount}}</td>

        </tr>
        @endforeach

    </tbody>

</table>

</div>	



</div>


@stop