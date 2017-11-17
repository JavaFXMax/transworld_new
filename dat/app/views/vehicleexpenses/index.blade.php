@extends('layouts.member')
@section('content')
<br/>

<div class="row">
	<div class="col-lg-12">
  <h3>Vehicle Expenses</h3>

<hr>
</div>	
</div>


<div class="row">
	<div class="col-lg-12">

    <div class="panel panel-default">
      <div class="panel-heading">
          <a class="btn btn-info btn-sm" href="{{ URL::to('vehicleexpenses/create')}}">Expenses</a>
        </div>
        <div class="panel-body">


    <table id="users" class="table table-condensed table-bordered table-responsive table-hover">


      <thead>

        <th>#</th>
         <th>Vehicle Make</th>
         <th>Registration Number</th>
         <th>Member</th>
         <th>Expense Incurred</th>
         <th>Amount</th>
         <th>Date</th>
        <th></th>

      </thead>
      <tbody>

        <?php $i = 1; ?>
        @foreach($vehicles as $vehicle)

        <tr>

          <td> {{ $i }}</td>
          <td>{{ Vehicle::assignedvehicle($vehicle->vehicle_id)->make }}</td>
          <td>{{ Vehicle::assignedvehicle($vehicle->vehicle_id)->regno }}</td>
          <td>{{ Member::getMemberName($vehicle->member_id) }}</td>
          <td>{{ $vehicle->expenseincurred }}</td>
          <td align="right">{{ number_format($vehicle->amount,2) }}</td>
          <td>{{ $vehicle->date }}</td>
          <td>

                  <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
          
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="{{URL::to('vehicleexpenses/edit/'.$vehicle->id)}}">Update</a></li>
                   
                   
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