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
          <strong><h3>MEMBER CONTRIBUTIONS STATEMENT </h3></strong>

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
     
      <table class="table table-bordered" style="width:60%">

       
          <tr>
            <td style="width:17%">Member</td><td>{{ucwords($member->name)}}</td>

          </tr>

          <tr>
            <td>Member #</td><td>{{ucwords($member->membership_no)}}</td>

          </tr>
         


          <tr>
            <td>Total Amount</td><td>{{asMoney(Contribution::sum($member->id))}}</td>

          </tr>

         


      </table>
      <br><br>
      


      <table class="table table-bordered" style="width:100%">



          <tr style="font-weight:bold">
              <td>Date</td>
              <td>Description</td>
              <td>Reason</td>
              <td>Debit(Dr)</td>
              <td>Credit(Cr)</td>
              
          </tr>

          <tbody>
         
          <?php
              $credit = 0;
              $debit  = 0;
             ?>
           


             @foreach($contributions as $transaction)

        <tr>

         
          <td>{{ $transaction->date }}</td>
           @if( $transaction->type == 'debit')
          <td >member contribution</td>
          @endif

          @if( $transaction->type == 'credit')
          <td >contribution missed</td>
          @endif

          <td>{{$transaction->reason}}</td>
          @if( $transaction->type == 'debit')
          <td >{{ asMoney($transaction->amount)}}</td>
          <td>0.00</td>
          <?php 
           $debit = $debit + $transaction->amount;
          ?>
          @endif

         

       @if( $transaction->type == 'credit')
       <td>0.00</td>
          <td>{{ asMoney($transaction->amount) }}</td>
          <?php 
           $credit = $credit + $transaction->amount;
          ?>
          @endif

           



        </tr>

       
        @endforeach

             
        
         <tr><td colspan="3" align="right"><strong>Total</strong></td><td><strong>{{asMoney($debit)}}</strong></td><td><strong>{{asMoney($credit)}}</strong></td></tr>
        



          </tbody>
      </table>















    
   </div>








 </body>
 </html>