<html>
  <head>
   <style>
     @page { margin: 170px 30px; }
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
          <strong><h3>SAVINGS LISTING REPORT</h3></strong>

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

          <td style="border-bottom:1px solid black;"><strong>Member #</strong></td>
          <td style="border-bottom:1px solid black;"><strong>Member Name</strong></td>
          <td style="border-bottom:1px solid black;"><strong>Saving Product</strong></td>
          <td style="border-bottom:1px solid black;"><strong>Account Number</strong></td>
          <td style="border-bottom:1px solid black;"><strong>Account Balance</strong></td>
        

        </tr>
        <?php $total = 0;?>
        @foreach($savings as $loan)

        @if(Savingtransaction::getDate($loan->id,$from,$to) == true)
        <tr>
          <td style="border-bottom:0.1px solid black; border-right:0.1px solid black;">{{$loan->member->membership_no}}</td>
           <td style="border-bottom:0.1px solid black; border-right:0.1px solid black;">{{$loan->member->name}}</td>
           <td style="border-bottom:0.1px solid black; border-right:0.1px solid black;">{{$loan->savingproduct->name}}</td>
           <td style="border-bottom:0.1px solid black; border-right:0.1px solid black;">{{$loan->account_number}}</td>
           <td style="border-bottom:0.1px solid black; border-right:0.1px solid black;">{{asMoney(Savingaccount::getAccountBalance($loan,$from,$to))}}</td>
           
        </tr>
        <?php $total = $total + Savingaccount::getAccountBalance($loan,$from,$to);?>
        @endif
        @endforeach
        <tr>
        <td align="right" colspan="4" style="border-bottom:0.1px solid black; border-right:0.1px solid black;"><strong>Total</strong></td>
        <td style="border-bottom:0.1px solid black; border-right:0.1px solid black;">{{asMoney($total,2)}}</td>
        </tr>

      </table>















    
   </div>








 </body>
 </html>