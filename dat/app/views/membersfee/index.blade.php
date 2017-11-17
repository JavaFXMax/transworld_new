@extends('layouts.member')
@section('content')
<br/>

<div class="row">
	<div class="col-lg-12">
  <h3>Member Registration Fee</h3>

<hr>
</div>	
</div>


<div class="row">
	<div class="col-lg-12">

    <div class="panel panel-default">
      <div class="panel-heading">
          <a class="btn btn-info btn-sm" href="{{ URL::to('membersfee/create')}}">New Member Fee</a>
        </div>
        <div class="panel-body">


    <table id="users" class="table table-condensed table-bordered table-responsive table-hover">


      <thead>

        <th>#</th>
        <th>Member Reg Fee</th>
        <th>Account</th>
        <th></th>

      </thead>
      <tbody>

        <?php $i = 1; ?>
        @foreach($memberfees as $memberfee)

        <tr>

          <td> {{ $i }}</td>
          <td>{{ $memberfee->member_registration_fee }}</td>
          <td>{{ $memberfee->account->name }}</td>
          <td>

                  <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
          
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="{{URL::to('membersfee/edit/'.$memberfee->id)}}">Update</a></li>
                   
                    <li><a href="{{URL::to('membersfee/delete/'.$memberfee->id)}}">Delete</a></li>
                    
                  </ul>
              </div>

                    </td>



        </tr>

        <?php $i++; ?>
        @endforeach


      </tbody>


    </table>
  </div>


  </div>

</div>
























@stop