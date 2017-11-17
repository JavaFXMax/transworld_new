@extends('layouts.member')
@section('content')
<br/>

<div class="row">
	<div class="col-lg-12">
  <h3>Vehicles</h3>

<hr>
</div>	
</div>


<div class="row">
	<div class="col-lg-12">

    <div class="panel panel-default">
      <div class="panel-heading">
        Members` Vehicle
          <!-- <a class="btn btn-info btn-sm" href="{{ URL::to('vehicles/create')}}">new vehicle</a> -->
        </div>
        <div class="panel-body">


    <table id="users" class="table table-condensed table-bordered table-responsive table-hover">


      <thead>

        <th>#</th>
         <th>Vehicle Make</th>
         <th>Registration Number</th>
        <th>Member</th>
        <th>Registration Fee</th>

      </thead>
      <tbody>

        <?php $i = 1; ?>
        @foreach($vehicles as $vehicle)

        <tr>

          <td> {{ $i }}</td>
          <td>{{ $vehicle->make }}</td>
          <td>{{ $vehicle->regno }}</td>
          <td>{{ Member::getMemberName($vehicle->member_id) }}</td>
             <td>{{ $vehicle->registration_fee }}</td>
          <!-- <td>

                  <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
          
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="{{URL::to('vehicles/edit/'.$vehicle->id)}}">Update</a></li>
                   
                    <li><a href="{{URL::to('vehicles/delete/'.$vehicle->id)}}">Delete</a></li>
                    
                  </ul>
              </div>

                    </td> -->



        </tr>

        <?php $i++; ?>
        @endforeach


      </tbody>


    </table>
  </div>


  </div>

</div>
























@stop