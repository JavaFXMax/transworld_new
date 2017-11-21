<?php
function asMoney($value) {
  return number_format($value, 2);
}
?>
<html>
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

@page { margin: 30px; }
     .header { position: fixed; left: 0px; top: -150px; right: 0px; height: 150px;  text-align: center; }
     .footer { position: fixed; left: 0px; bottom: -180px; right: 0px; height: 50px;  }
     .footer .page:after { content: counter(page, upper-roman); }
</style>
</head>
<div class="footer">
     <p class="page">Page <?php $PAGE_NUM ?></p>
   </div>
<div class="content" >
     <table class="table table-bordered">
      <tr>
        <td>
        <strong>
          {{ strtoupper($organization->name)}}<br>
          </strong>
          {{ $organization->phone}}<br>
          {{ $organization->email}}<br>
          {{ $organization->website}}<br>
          {{ $organization->address}}
        </td>
      </tr>
      <tr>
        <hr>
      </tr>
    </table>
<table class="table table-bordered">
     <tr>
        <td align="center"><strong>MEMBER PERSONAL STATEMENT</strong></td>
      </tr>
      <tr>
        <hr>
      </tr>
      </table>
<br>
    <table class="table table-bordered" style="width:50%;">
      <tr>
        <td>Member:</td><td> {{ $member->name}}</td>
      </tr>
      <tr>
        <td>Member #:</td><td> {{ $member->membership_no}}</td>
      </tr>
      @if(!empty($member->email))
      <tr>
        <td>Member Email :</td><td> {{ $member->email}}</td>
      </tr>
      @endif
      <tr>
        <td>Share Capital</td>
        <td>
            <strong>{{asMoney($shares_amount)}}</strong>
                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
            <strong>{{strtoupper($shares_status)}}</strong>
        </td>
      </tr>
      <tr>
        <td>Statement Period :</td><td> <strong>{{ date('d-M-Y',strtotime($from))}} </strong>  to
          <strong>{{ date('d-M-Y',strtotime($to))}}</strong> </td>
      </tr>
      <tr>
        @if($vehicles_count >1)
        <td>Vehicles:</td>
        @else
        <td>Vehicle: </td>
        @endif
        <td>
          @foreach($vehicles as $vehicle)
                <strong>{{$vehicle->regno}}&#44;</strong>
          @endforeach
        </td>
      </tr>
      <tr>
        <hr>
      </tr>
    </table>
<br>
     <table class="table table-bordered">
       <tr>
         <td><strong>Date</strong></td>
         <td></td>
         <td colspan="2"><strong>Deposits</strong></td>
         <td colspan="2"><strong>P. Scheme</strong></td>
         <td colspan="2"><strong>Investment/PS</strong></td>
         <td colspan="2"><strong>Loans</strong></td>
         <td><strong>Interest</strong></td>
       </tr>
       <tr>
         <td></td>
         <td style="text-decoration:underline;font-weight:bold;">Details</td>
         <td style="text-decoration:underline;font-weight:bold;">Rcvd. </td>
         <td style="text-decoration:underline;font-weight:bold;">Total</td>
         <td style="text-decoration:underline;font-weight:bold;">Paid</td>
         <td style="text-decoration:underline;font-weight:bold;">Bal</td>
         <td style="text-decoration:underline;font-weight:bold;">Rcvd</td>
         <td style="text-decoration:underline;font-weight:bold;">Total</td>
         <td style="text-decoration:underline;font-weight:bold;">Paid</td>
         <td style="text-decoration:underline;font-weight:bold;">Bal</td>
         <td style="text-decoration:underline;font-weight:bold;">Charge</td>
       </tr>
       <tr>
         <td style="text-decoration:underline;font-weight:bold;">Bal B/F</td>
         <td></td>
         <td>-</td>
         <td><strong>{{asMoney($member_deposits_balance)}}</strong></td>
         <td>- </td>
         <td><strong>{{asMoney($pension_amount_balance)}}</strong></td>
         <td>-</td>
         <td><strong>{{asMoney($petrol_amount_balance)}}</strong></td>
         <td>-</td>
         <td><strong>{{asMoney($loan_balance)}}</strong></td>
         <td>- </td>
       </tr>
      <?php
            $deposits_balance= $member_deposits_balance;
            $pension_balance= $pension_amount_balance;
            $petrol_balance =$petrol_amount_balance;
            $loan_balances= $loan_balance;
        ?>
       @foreach($incomes as $income)
       <tr>
         <td>{{$income->date}}</td>
         <?php
                $vehicle= Vehicle::where('id','=',$income->vehicle_id)->get()->first();
                if(!empty($income->loantransaction_id)){
                  $loan_amount= Loantransaction::where('id','=',$income->loantransaction_id)->get()->first();
                }
                if(empty($income->loantransaction_id)){
                  $loan_amount=0;
                }
                if(!empty($income->sharetransaction_id)){
                          $share_transaction_petrol = Sharetransaction::where('id','=',$income->sharetransaction_id)
                          ->where('pay_for','=','petrol')->get()->first();
                          if(!empty($share_transaction_petrol)){
                                $petrol_amount = $share_transaction_petrol->amount;
                          }
                          if(empty($share_transaction_petrol)){
                                $petrol_amount = 0;
                          }
                }
                if(empty($income->sharetransaction_id)){
                  $loan_amount= 0;
                }
                if(!empty($income->savingtransaction_id)){
                      $saving_transaction= Savingtransaction::where('id','=',$income->savingtransaction_id)->get()->first();
                      $saving_product_id= Savingaccount::where('id','=',$saving_transaction->savingaccount_id)->pluck('savingproduct_id');
                      if($saving_product_id ===1){
                            $member_deposits= Savingtransaction::where('id','=',$income->savingtransaction_id)->pluck('amount');
                      }
                      if($saving_product_id ===2){
                            $pension_amount= Savingtransaction::where('id','=',$income->savingtransaction_id)->pluck('amount');
                      }
                }
                if(empty($income->savingtransaction_id)){
                      $member_deposits= 0;
                      $pension_amount=0;
                }
          ?>
         <td>{{$vehicle->regno}}</td>
         <td>{{asMoney($member_deposits)}}</td>
         <td>{{asMoney($deposits_balance)}}</td>
         <td>{{asMoney($pension_amount)}}</td>
         <td>{{asMoney($pension_balance)}}</td>
         <td>{{asMoney($petrol_amount)}}</td>
         <td>{{asMoney($petrol_balance)}}</td>
         <td>{{asMoney($loan_amount)}}</td>
         <td>{{asMoney($loan_balances)}}</td>
         <td>Charge</td>
       </tr>
       <?php
              $deposits_balance +=$member_deposits;
              $pension_balance +=$pension_amount;
              $petrol_balance +=$petrol_amount;
              $loan_balances -=$loan_amount;
        ?>
       @endforeach
    </table>
<br>
     <table class="table table-bordered">
      <tr>
        <td style="width:80px;"> Served By </td>
        <td>  {{Confide::user()->username}} </td>
      </tr>
      <tr>
        <hr>
      </tr>
    </table>
 <p>Thank you for saving with us</p>
  </div>
</div>
</html>
