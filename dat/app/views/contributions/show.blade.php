@extends('layouts.member')
@section('content')
<br/>

<?php


function asMoney($value) {
  return number_format($value, 2);
}

?>

<div class="row">
	<div class="col-lg-5">
 
 <table class="table table-condensed table-bordered table-hover">

   <tr>
    <td>Member Name:</td><td>{{ $member->name}}</td>
</tr>
<tr>
    <td>Member No:</td><td>{{ $member->membership_no}}</td>
</tr>


<tr>
    <td>Total Contributions:</td><td>{{ asMoney(Contribution::sum($member->id)) }}</td>
</tr>

 </table>


</div>	
</div>


<div class="row">
	<div class="col-lg-12">

    
		
		 <hr>

		

  </div>

</div>




<div class="row">
    <div class="col-lg-12">

       @if(Session::get('notice'))
            <div class="alert alert-success">{{ Session::get('notice') }}</div>
        @endif

    <div class="panel panel-default">
      <div class="panel-heading">
      <a target="blank" href="{{URL::to('contributions/statement/'.$member->id)}}" class="pull-right"> <i class="glyphicon glyphicon-file"></i> statement </a>
          <a class="btn btn-info btn-sm" href="{{ URL::to('contributions/create/'.$member->id)}}"> New Contribution</a>
        </div>
        <div class="panel-body">


    <table id="users" class="table table-condensed table-striped table-responsive table-hover">


      <thead>

        
        <th>Date</th>
        <th>Description</th>
        <th>Reason</th>
        <th>Debit (DR)</th>
         <th>Credit (CR)</th>
         <th></th>
     

      </thead>
      <tbody>

      
        @foreach($contributions as $transaction)

        <tr>

         
          <td>{{ $transaction->date }}</td>
           @if( $transaction->type == 'debit')
          <td >member contribution</td>
          @endif

          @if( $transaction->type == 'credit')
          <td >contribution missed</td>
          @endif
          <td >{{ $transaction->reason }}</td>
          @if( $transaction->type == 'debit')
          <td >{{ asMoney($transaction->amount)}}</td>
          <td>0.00</td>
          @endif

       @if( $transaction->type == 'credit')
       <td>0.00</td>
          <td>{{ asMoney($transaction->amount) }}</td>
          @endif

           <td>

<a  href="{{ URL::to('contributions/void/'.$transaction->id)}}" > <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Void</a>


          </td> 



        </tr>

       
        @endforeach


      </tbody>


    </table>
  </div>


  </div>

</div>






















@stop