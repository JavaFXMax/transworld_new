
<?php


function asMoney($value) {
  return number_format($value, 2);
}

?>
<html>
  <head>

   <style>
     @page { margin: 170px 30px; }
     .header { position: fixed; left: 0px; top: -150px; right: 0px; height: 150px;  text-align: center; }
     .footer { position: fixed; left: 0px; bottom: -180px; right: 0px; height: 50px;  }
     .footer .page:after { content: counter(page, upper-roman); }

   </style>
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

     
     <table class="table table-condensed table-bordered" style="width:60%">


        <tr>

          <td>Member</td><td>{{$loanaccount->member->name}}</td>
        </tr>
        <tr>

          <td>Loan Account</td><td>{{$loanaccount->account_number}}</td>
        </tr>

        <tr>

          <td>Principal Balance</td><td>{{ asMoney($principal_due) }}</td>
        </tr>

       
       

       </table>

       <br>

       <table class="table table-condensed table-bordered" style="width:60%">


        <tr >

          <td>Principal Due</td><td>{{ asMoney($principal_due) }}</td>

        </tr>
        
        <tr>

          <td>Interest Due</td><td>{{ asMoney($interest_due) }}</td>
        </tr>


       

          <td>Total Due</td><td>{{ asMoney($principal_due + $interest_due)}}</td>
        </tr>
        </table>
<br>

        <hr>


   </div>
 </body>
 </html>