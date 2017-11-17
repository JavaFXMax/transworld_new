<html>
  <head>
   <style>
     @page { margin: 170px 30px; }
     .header { position: fixed; left: 0px; top: -150px; right: 0px; height: 150px;  text-align: center; }
     .footer { position: fixed; left: 0px; bottom: -180px; right: 0px; height: 50px;  }
     .footer .page:after { content: counter(page, upper-roman); }
     .content { margin-top: 0px;  }
      
   </style>
  <body style="font-size:10px">
<?php


function asMoney($value) {
  return number_format($value, 2);
}

?>

    
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

        <td>
          @if($vehicle_id=='All')
          <strong><h3>VEHICLE INCOME STATEMENT FOR PERIOD BETWEEN {{$from.' and '.$to}} </h3></strong>
          @else
          <strong><h3>{{strtoupper(Vehicle::assignedvehicle($vehicle_id)->make.' - '.Vehicle::assignedvehicle($vehicle_id)->regno)}} INCOME STATEMENT FOR PERIOD BETWEEN {{$from.' and '.$to}} </h3></strong>
          @endif
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
     

      <table class="table table-bordered" style="width:100%">

        <tr>
         
          <td style="border-bottom:1px solid black;"><strong>VEHICLE</strong></td>
          <td style="border-bottom:1px solid black;"><strong>AMOUNT</strong></td>
        

        </tr>


        <tr>
          <td style="border-bottom:1px solid black;"><strong>INCOME</strong></td>
          <td style="border-bottom:1px solid black;"></td>
          
            <?php $total_income =0; ?>

        </tr>


        @foreach($vehicleincomes as $vehicle)
        <tr>
         
          <td style="border-bottom:0.5px solid gray;">{{ Vehicle::assignedvehicle($vehicle->vehicle_id)->make.' - '.Vehicle::assignedvehicle($vehicle->vehicle_id)->regno }}</td>
          <td style="border-bottom:0.5px solid gray;">{{asMoney($vehicle->amount)}}</td>
         
          
        
          <?php $total_income = $total_income + $vehicle->amount; ?>
        </tr>
        @endforeach
        <tr>
          <td style="border-top:1px solid black; border-bottom:1px solid black;"><strong>TOTAL INCOME</strong></td>
          
          <td style="border-top:1px solid black; border-bottom:1px solid black;"><strong>{{asMoney($total_income)}}</strong></td>
        
          

        </tr>

<tr>
<td><br></td>
</tr>


         <tr>
          <td style="border-bottom:1px solid black;"><strong>EXPENSE</strong></td>
          <td style="border-bottom:1px solid black;"></td>
          
            <?php $total_expense =0; ?>

        </tr>


        @foreach($vehicleexpenses as $vehicle)
        <tr>

          <td style="border-bottom:0.5px solid gray;">{{ $vehicle->expenseincurred }}</td>
          <td style="border-bottom:0.5px solid gray;">{{asMoney($vehicle->amount)}}</td>
        
          <?php $total_expense = $total_expense + $vehicle->amount; ?>
        </tr>
        @endforeach
        <tr>
          <td style="border-top:1px solid black; border-bottom:1px solid black;"><strong>TOTAL EXPENSE</strong></td>
          <td style="border-top:1px solid black; border-bottom:1px solid black;"><strong>{{asMoney($total_expense)}}</strong></td>
          
          

        </tr>




        </tr>

<tr>
<td><br></td>
</tr>

<tr>
          <td style="border-top:1px solid black; border-bottom:1px solid black;"><strong>NET VALUE</strong></td>
          <td style="border-top:1px solid black; border-bottom:1px solid black;"><strong>{{asMoney($total_income - $total_expense)}}</strong></td>
          
          

        </tr>


       


       


      </table>















    
   </div>








 </body>
 </html>