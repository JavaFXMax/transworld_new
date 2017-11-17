@extends('layouts.ports')
@section('content')
<br/>





<div class="row">
	<div class="col-lg-12">
  <h3> Savings Reports</h3>

<hr>
</div>	
</div>


<div class="row">
	<div class="col-lg-12">

    <ul>

      <li>

        <a href="{{ URL::to('reports/savingperiod') }}"> Savings Listing report</a>

      </li>


       <li>

        <a href="{{ URL::to('reports/savingproductperiod')}}" >Saving Products report</a>

      </li>      


    </ul>

  </div>

</div>
























@stop