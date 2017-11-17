@extends('layouts.member')
@section('content')
<br/>

<div class="row">
	<div class="col-lg-12">
  <h3>TLB Payments</h3>

<hr>
</div>	
</div>


<div class="row">
	<div class="col-lg-12">

    <div class="panel panel-default">
      <div class="panel-heading">
          <a class="btn btn-info btn-sm" href="{{ URL::to('tlbpayments/create')}}">New Member Fee</a>
        </div>
        <div class="panel-body">


    <table id="users" class="table table-condensed table-bordered table-responsive table-hover">


      <thead>

        <th>#</th>
        <th>Vehicle</th>
        <th>Amount</th>
        <th>Date</th>
        <th>Account</th>
        <th></th>

      </thead>
      <tbody>

        <?php $i = 1; ?>
        @foreach($tlbs as $tlb)

        <tr>

          <td> {{ $i }}</td>
          <td>{{ $tlb->vehicle->make.' '.$tlb->vehicle->regno }}</td>
          <td>{{ $tlb->amount }}</td>
          <td>{{ $tlb->date }}</td>
          <td>{{ $tlb->account->name }}</td>
          <td>

                  <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
          
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="{{URL::to('tlbpayments/edit/'.$tlb->id)}}">Update</a></li>
                   
                    <li><a href="{{URL::to('tlbpayments/delete/'.$tlb->id)}}">Delete</a></li>
                    
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