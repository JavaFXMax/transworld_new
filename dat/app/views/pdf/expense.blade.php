<?php


function asMoney($value) {
  return number_format($value, 2);
}

?>
<html >



<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<style type="text/css">

table {
  max-width: 100%;
  background-color: transparent;
}
th {
  text-align: left;
}
.table {
  width: 100%;
  margin-bottom: 2px;
}
hr {
  margin-top: 1px;
  margin-bottom: 2px;
  border: 0;
  border-top: 2px dotted #eee;
}

body {
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  font-size: 12px;
  line-height: 1.428571429;
  color: #333;
  background-color: #fff;
}



 @page { margin: 170px 30px; }
 .header { position: fixed; left: 0px; top: -150px; right: 0px; height: 150px;  text-align: center; }
 .content {margin-top: -100px; margin-bottom: -150px}
 .footer { position: fixed; left: 0px; bottom: -180px; right: 0px; height: 50px;  }
 .footer .page:after { content: counter(page, upper-roman); }



</style>

</head>

<body>

  <div class="header">
     <table >

      <tr>


       
        <td style="width:150px">

            <img src="{{asset('public/uploads/logo/'.$organization->logo)}}" alt="logo" width="150">
    
        </td>

        <td>
        <strong>
          {{ strtoupper($organization->name)}}<br>
          </strong>
          {{ $organization->phone}} |
          {{ $organization->email}} |
          {{ $organization->website}}<br>
          {{ $organization->address}}
       

        </td>
        

      </tr>


      <tr>

        <hr>
      </tr>



    </table>
   </div>



<div class="footer">
     <p class="page">Page <?php $PAGE_NUM ?></p>
   </div>







	<div class="content">
  @if($vehicle_id=='All')
  <div align="center"><h3>{{$type.' statement for period between '.$from.' and '.$to}}</h3></div>
  @else
  <div align="center"><h3>{{$type.' statement for '.Vehicle::assignedvehicle($vehicle_id)->make.' - '.Vehicle::assignedvehicle($vehicle_id)->regno.' for period between '.$from.' and '.$to}}</h3></div>
   @endif
    <table class="table table-bordered">

      <tr>
        

        @if($vehicle_id=='All')
        <td style="border-bottom:1px solid black;"><strong># </strong></td>
        <td style="border-bottom:1px solid black;"><strong>Vehicle Make </strong></td>
        <td style="border-bottom:1px solid black;"><strong>Registration Number </strong></td>
        @if($type == 'Expense')
        <td style="border-bottom:1px solid black;"><strong>Expense Incurred</strong></td>
        @else

        @endif

        <td style="border-bottom:1px solid black;"><strong>Amount ({{$currency->shortname}}) </strong></td>
        @else
        <td style="border-bottom:1px solid black;"><strong># </strong></td>
        @if($type == 'Expense')
        <td style="border-bottom:1px solid black;"><strong>Expense Incurred</strong></td>
        @else

        @endif
        <td style="border-bottom:1px solid black;"><strong>Amount ({{$currency->shortname}}) </strong></td>
        @endif

      </tr>
      <?php $i = 1; 
        $total = 0;
      ?>
      @if($vehicle_id=='All')
      @foreach($vehicles as $vehicle)
      <tr>


       <td style="border-bottom:0.1px solid black; border-right:0.1px solid black;">{{$i}}</td>
        <td style="border-bottom:0.1px solid black; border-right:0.1px solid black;">{{Vehicle::assignedvehicle($vehicle->vehicle_id)->make}}</td>
        <td style="border-bottom:0.1px solid black; border-right:0.1px solid black;">{{Vehicle::assignedvehicle($vehicle->vehicle_id)->regno}}</td>
        @if($type == 'Expense')
        <td style="border-bottom:0.1px solid black; border-right:0.1px solid black;">{{$vehicle->expenseincurred}}</td>
        @else

        @endif
        <td align="right" style="border-bottom:0.1px solid black; border-right:0.1px solid black;">{{number_format($vehicle->amount,2)}}</td>
       </tr>

      <?php
       $total = $total + $vehicle->amount;
       $i++; ?>
   
    @endforeach
      @if($type == 'Expense')
      <tr><td align="right" colspan="4" style="border-bottom:0.1px solid black; border-right:0.1px solid black;"><strong>Net Value</strong></td><td align="right" style="border-bottom:0.1px solid black; border-right:0.1px solid black;"><strong>{{number_format($total,2)}}</strong></td></tr>
    @else
      <tr><td align="right" colspan="3" style="border-bottom:0.1px solid black; border-right:0.1px solid black;"><strong>Net Value</strong></td><td align="right" style="border-bottom:0.1px solid black; border-right:0.1px solid black;"><strong>{{number_format($total,2)}}</strong></td></tr>
    @endif
     @else
      @foreach($vehicles as $vehicle)
      <tr>


       <td style="border-bottom:0.1px solid black; border-right:0.1px solid black;">{{$i}}</td>
       @if($type == 'Expense')
        <td style="border-bottom:0.1px solid black; border-right:0.1px solid black;">{{$vehicle->expenseincurred}}</td>
       @else

       @endif
        <td align="right" style="border-bottom:0.1px solid black; border-right:0.1px solid black;">{{number_format($vehicle->amount,2)}}</td>
       
       </tr>

      <?php
       $total = $total + $vehicle->amount;
       $i++; ?>
   
    @endforeach
    @if($type == 'Expense')
      <tr><td align="right" colspan='2' style="border-bottom:0.1px solid black; border-right:0.1px solid black;"><strong>Net Value</strong></td><td align="right" style="border-bottom:0.1px solid black; border-right:0.1px solid black;"><strong>{{number_format($total,2)}}</strong></td></tr>
     @else
      <tr><td align="right" style="border-bottom:0.1px solid black; border-right:0.1px solid black;"><strong>Net Value</strong></td><td align="right" style="border-bottom:0.1px solid black; border-right:0.1px solid black;"><strong>{{number_format($total,2)}}</strong></td></tr>
    @endif
     @endif


    </table>

<br><br>

    





   
</div>


</body>

</html>



