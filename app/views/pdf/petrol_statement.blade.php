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
     <table>
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
          <strong><h3>PETROL STATION INVESTMENT STATEMENT </h3></strong>
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
      <table class="table table-bordered">
          <tr>
            <td style="width:17%">Member</td><td>{{ucwords($member->name)}}</td>
          </tr>
          <tr>
            <td>Member #</td><td>{{ucwords($member->membership_no)}}</td>
          </tr>
          <tr>
            <td> Account #</td><td>{{$shares_account->account_number}}</td>
          </tr>
          <tr>
             <td>Period:</td><td><strong>{{date('d-M-Y', strtotime($from)).'   to  '.date('d-M-Y', strtotime($to))}}</strong></td>
           </tr>
          <tr>
            <td><strong>Total Amount :</strong></td><td><strong>{{asMoney($petrol_amount)}}</strong></td>
          </tr>
      </table>
      <br><br>
      <table class="table table-bordered" style="width:100%">
          <tr style="font-weight:bold">
              <td>#</td>
              <td>Date</td>
              <td>Description</td>
              <td>Amount</td>
          </tr>
          <tbody>
            <?php $i=1;?>
            @foreach($transactions as $transaction)
             <tr>
               <td>{{$i}}</td>
               <?php $date = date("d-M-Y", strtotime($transaction->date));?>
                <td>{{$date}}</td>
                <td>{{$transaction->description}} </td>
                <td>{{asMoney($transaction->amount)}}</td>
              </tr>
              <?php $i++;?>
              @endforeach
          </tbody>
      </table>
   </div>
 </body>
 </html>
