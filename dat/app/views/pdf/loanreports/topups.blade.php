<html>
  <head>
    <title>Loan Listing Report</title>
   <style>
     @page { margin: 170px 30px; }
     .header { position: fixed; left: 0px; top: -150px; right: 0px; height: 150px;  text-align: center; }
     .footer { position: fixed; left: 0px; bottom: -180px; right: 0px; height: 50px;  }
     .footer .page:after { content: counter(page, upper-roman); }
     .content { margin-top: 0px;  }
      
   </style>
 </head>
  <body style="font-size:11px">
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
          <strong><h3>TOP UP LISTING REPORT</h3></strong>

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
     <h5 style="text-decoration: underline;">
       {{strtoupper($loanaccount->member->name)}} LOAN TOP UPS
     </h5>

      <table class="table table-bordered" style="width:100%">


        <tr>

          <td style="border-bottom:1px solid black;"><strong>Top-up Amount</strong></td>
          <td style="border-bottom:1px solid black;"><strong>Top-up Interest</strong></td>
          <td style="border-bottom:1px solid black;"><strong>Total Amount Payable</strong></td>
          <td style="border-bottom:1px solid black;"><strong>Date Topped Up</strong></td        
        </tr>
        <?php $total = 0;?>
        @foreach($topups as $topup)        
        <tr>
          <td style="border-bottom:0.1px solid black; border-right:0.1px solid black;">{{asMoney($topup->amount)}}</td>
           <td style="border-bottom:0.1px solid black; border-right:0.1px solid black;">{{asMoney($topup->total_payable-$topup->amount)}}</td>
           <td style="border-bottom:0.1px solid black; border-right:0.1px solid black;">{{asMoney($topup->total_payable)}}</td>
           <td style="border-bottom:0.1px solid black; border-right:0.1px solid black;">{{$topup->created_at}}</td>            
        </tr>  
        <?php $total = $total + $topup->total_payable;?>      
        @endforeach  
        <tr>
        <td align="right" colspan="3" style="border-bottom:0.1px solid black; border-right:0.1px solid black;"><strong>Total Amount Payable</strong></td>
        <td style="border-bottom:0.1px solid black; border-right:0.1px solid black;">
         <strong>{{asMoney($total,2)}}</strong>
        </td>
        </tr>    
      </table>
   </div>
 </body>
 </html>