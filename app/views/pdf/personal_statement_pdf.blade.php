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
        <td style="width:150px">
             <img src="{{ asset('public/uploads/logo/'.$organization->logo ) }}" alt="{{ $organization->logo }}" width="150px" height="150px"/>
        </td>
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
        <hr style="border-top:2px solid #ddd;">
      </tr>
    </table>
<br>
      @if(($vehicles_count >0) && (count($incomes)>0))
            <center><h3>VEHICLE INCOMES    Total b/f :   {{asMoney($income_balance)}}</h3></center>
            <hr>
           <table class="table table-bordered">
             <tr>
               <td style="font-weight:bold;">#</td>
               <td style="font-weight:bold;">Date</td>
               <td style="font-weight:bold;">Vehicle</td>
               <td style="font-weight:bold;">Amount</td>
               <td style="font-weight:bold;">Total</td>
             </tr>
             <?php
                    $i=1;
                    $in_balance= $income_balance;
             ?>
            @foreach($incomes as $income)
             <tr>
               <td>{{$i}}</td>
               <td>{{date('d-M-Y',strtotime($income->date))}}</td>
               <td>{{Vehicle::where('id',$income->vehicle_id)->pluck('regno')}}</td>
               <td>{{asMoney($income->amount)}}</td>
               <td>{{asMoney($income->amount + $in_balance)}}</td>
             </tr>
             <?php
                  $i++;
                  $in_balance+=$income->amount;
             ?>
             @endforeach
          </table>
          <hr style="border-top:2px solid #ddd;">
    @endif
    @if($deposits_count > 0)
          <center>
              <h3>
                MEMBER DEPOSITS   Total b/f :   {{asMoney($member_deposits_balance)}}
              </h3>
            </center>
            <hr>
         <table class="table table-bordered">
           <tr>
             <td style="font-weight:bold;">#</td>
             <td style="font-weight:bold;">Date</td>
             <td style="font-weight:bold;">Payment Mode</td>
             <td style="font-weight:bold;">Amount</td>
             <td style="font-weight:bold;">Total</td>
           </tr>
           <?php
                  $i=1;
                  $deposits_bal= $member_deposits_balance;
          ?>
          @foreach($member_deposits as $deposit)
           <tr>
             <td>{{$i}}</td>
             <td>{{date('d-M-Y',strtotime($deposit->date))}}</td>
             <?php
                  if($deposit->payment_via === 'Vehicle'){
                          $transaction_id= $deposit->id;
                          $vehicle= Vehicleincome::where('savingtransaction_id','=',$transaction_id)->pluck('vehicle_id');
                          $regno = Vehicle::where('id','=',$vehicle)->pluck('regno');
                          $payment = 'Vehicle '.  '   -  '  .$regno;
                  }
                  if($deposit->payment_via != 'Vehicle'){
                        $payment=$deposit->payment_via;
                  }
             ?>
             <td>{{$payment}}</td>
             <td>{{asMoney($deposit->amount)}}</td>
             <td>{{asMoney($deposit->amount + $deposits_bal)}}</td>
           </tr>
           <?php
                  $i++;
                  $deposits_bal +=$deposit->amount;
           ?>
           @endforeach
        </table>
        <hr style="border-top:2px solid #ddd;">
        @endif
        @if($pension_count >0 )
            <center>
                <h3>
                  PENSION SCHEME   Total b/f :   {{asMoney($pension_amount_balance)}}
                </h3>
              </center>
              <hr>
           <table class="table table-bordered">
             <tr>
               <td style="font-weight:bold;">#</td>
               <td style="font-weight:bold;">Date</td>
               <td style="font-weight:bold;">Payment Mode</td>
               <td style="font-weight:bold;">Amount</td>
               <td style="font-weight:bold;">Total</td>
             </tr>
             <?php
                  $i=1;
                  $pension_bal=$pension_amount_balance;
              ?>
            @foreach($pensions as $pension)
             <tr>
               <td>{{$i}}</td>
               <td>{{date('d-M-Y',strtotime($pension->date))}}</td>
               <?php
                    if($pension->payment_via === 'Vehicle'){
                            $transaction_id= $pension->id;
                            $vehicle= Vehicleincome::where('savingtransaction_id','=',$transaction_id)->pluck('vehicle_id');
                            $regno = Vehicle::where('id','=',$vehicle)->pluck('regno');
                            $payment = 'Vehicle '. $regno;
                    }
                    if($pension->payment_via != 'Vehicle'){
                          $payment=$pension->payment_via;
                    }
               ?>
               <td>{{$payment}}</td>
               <td>{{asMoney($pension->amount)}}</td>
               <td>{{asMoney($pension->amount + $pension_bal)}}</td>
             </tr>
             <?php
                  $i++;
                  $pension_bal += $pension->amount;
             ?>
             @endforeach
          </table>
          <hr style="border-top:2px solid #ddd;">
          @endif
          <!-- PETROL INVESTMENT-->
          @if($petrol_count)
              <center>
                  <h3>
                    PETROL STATION INVESTMENT
                        Total b/f :   {{asMoney($petrol_amount_balance)}}
                  </h3>
                </center>
                <hr>
             <table class="table table-bordered">
               <tr>
                 <td style="font-weight:bold;">#</td>
                 <td style="font-weight:bold;">Date</td>
                 <td style="font-weight:bold;">Description</td>
                 <td style="font-weight:bold;">Amount</td>
                 <td style="font-weight:bold;">Total</td>
               </tr>
               <?php
                    $i=1;
                    $ps_balance= $petrol_amount_balance;
               ?>
              @foreach($petrol_trans as $trans)
               <tr>
                 <td>{{$i}}</td>
                 <td>{{date('d-M-Y',strtotime($trans->date))}}</td>
                 <td>{{$trans->description}}</td>
                 <td>{{asMoney($trans->amount)}}</td>
                 <td>{{asMoney($ps_balance+$trans->amount)}}</td>
               </tr>
               <?php
                        $i++;
                        $ps_balance +=$trans->amount;
               ?>
               @endforeach
            </table>
            <hr style="border-top:2px solid #ddd;">
            @endif
            <!-- LOAN BALANCES-->
            @if($loans_counter>0)
                <center>
                    <h3>
                      LOAN ACCOUNTS TRANSACTION
                          Total b/f :   {{asMoney($loan_balance)}}
                    </h3>
                  </center>
                  <hr>
               <table class="table table-bordered">
                 <tr>
                   <td style="font-weight:bold;">#</td>
                   <td style="font-weight:bold;">Loan Account</td>
                   <td style="font-weight:bold;">Date Paid</td>
                   <td style="font-weight:bold;">Principal </td>
                   <td style="font-weight:bold;">Interest</td>
                   <td style="font-weight:bold;">Balance</td>
                 </tr>
                @foreach($loans as $loan)
                              <?php
                                  $loan_bal= $loan_balance;
                                  $repayments=Loanrepayment::where('loanaccount_id','=',$loan->id)->get();
                                  $x=1;
                               ?>
                               @foreach($repayments as $repayment)
                             <tr>
                               <td>{{$x}}</td>
                               <td>{{$loan->account_number}}</td>
                               <td>{{date('d-M-Y',strtotime($repayment->date))}}</td>
                               <td>{{asMoney($repayment->principal_paid)}}</td>
                               <td>{{asMoney($repayment->interest_paid)}}</td>
                               <?php
                                      $total_repayment=$repayment->principal_paid+ $repayment->interest_paid;
                                ?>
                               <td>{{asMoney($loan_bal-$total_repayment)}}</td>
                               <?php
                                        $loan_bal -=$total_repayment;
                                        $x++;
                              ?>
                             </tr>
                             @endforeach
                 @endforeach
              </table>
              <hr style="border-top:2px solid #ddd;">
              @endif
            <br><br>
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
