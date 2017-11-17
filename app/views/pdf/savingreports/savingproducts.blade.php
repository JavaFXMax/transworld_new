<html>
  <head>
   <style>
     @page { margin: 30px; }
     .header { position: fixed; left: 0px; top: -150px; right: 0px; height: 150px;  text-align: center; }
     .footer { position: fixed; left: 0px; bottom: -180px; right: 0px; height: 50px;  }
     .footer .page:after { content: counter(page, upper-roman); }
     .content { margin-top: 0px;  }
      
   </style>
  <body style="font-size:13px">
<?php


function asMoney($value) {
  return number_format($value, 2);
}

?>


   <div class="footer">
     <p class="page">Page <?php $PAGE_NUM ?></p>
   </div>



   <div class="content">

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
          <strong><h3>{{$member->name}} SAVINGS REPORT</h3></strong>

        </td>
        

      </tr>


      <tr>

        <hr>
      </tr>



    </table>
    <br><br>
     <table class="table table-bordered" style="width:60%">

       
          <tr>
            <td style="width:30%">Member</td><td>{{ucwords($member->name)}}</td>

          </tr>

          <tr>
            <td>Member #</td><td>{{ucwords($member->membership_no)}}</td>

          </tr>

          <tr>
          <td>Account No</td><td>{{$saving->account_number}}</td>
          </tr> 

          <tr>
          <td>Product</td><td>{{$product->name}}</td>
          </tr>   

          <tr>
          <td>Account Balance</td><td>{{asMoney(Savingaccount::getMemberBalance($saving,$from,$to),2)}}</td>
          </tr>  

          <tr>
          <td>Period</td><td>{{$from.' to '.$to}}</td>
          </tr>  
         

      </table>
      <br><br>

      <table class="table table-bordered" style="width:100%">


        <tr>
          <td style="border-bottom:1px solid black;"><strong>Date</strong></td>
          <td style="border-bottom:1px solid black;"><strong>Deposits</strong></td>
          <td style="border-bottom:1px solid black;"><strong>Withdrawals</strong></td>

        </tr>
         <?php $credit = 0;$debit=0;?>
        @foreach($transactions as $loan)
        
        <tr>
           <td style="border-bottom:0.1px solid black; border-right:0.1px solid black;">{{$loan->date}}</td>
           @if( $loan->type == 'credit')
           <td align="right" style="border-bottom:0.1px solid black; border-right:0.1px solid black;">{{asMoney($loan->amount)}}</td>
           <td align="right" style="border-bottom:0.1px solid black; border-right:0.1px solid black;">0.00</td>
          <?php $credit = $credit + $loan->amount;?>
          @endif
          @if( $loan->type == 'debit')
           <td align="right" style="border-bottom:0.1px solid black; border-right:0.1px solid black;">0.00</td>
           <td align="right" style="border-bottom:0.1px solid black; border-right:0.1px solid black;">{{asMoney($loan->amount)}}</td>
         <?php $debit = $debit + $loan->amount;?>
          @endif
        </tr>
              
             
        @endforeach
       <tr>
        <td align="right" style="border-bottom:0.1px solid black; border-right:0.1px solid black;"><strong>Total</strong></td>
        <td align="right" style="border-bottom:0.1px solid black; border-right:0.1px solid black;"><strong>{{asMoney($credit,2)}}</strong></td>
        <td align="right" style="border-bottom:0.1px solid black; border-right:0.1px solid black;"><strong>{{asMoney($debit,2)}}</strong></td>
        </tr>

      </table>















    
   </div>








 </body>
 </html>