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

            <img src="{{asset('public/uploads/logo/'.$organization->logo)}}" alt="logo" width="150">
    
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

        <td align="center"><strong>MEMBER STATEMENT</strong></td>
      </tr>

      <tr>

        <hr>
      </tr>

      
      </table>
   
<br>


    <table class="table table-bordered">
    
      <tr>

       
        <td>Member:</td><td> {{ $member->name}}</td>
      </tr>
      <tr>

        <td>Member #:</td><td> {{ $member->membership_no}}</td>

        </tr>

      <tr>
        
        <td>Branch :</td><td> {{ $member->branch->name}}</td>

      </tr>


      <tr>

        <hr>
      </tr>



    </table>

<br>

     <table class="table table-bordered">
         
       <?php $net = 0;?>
       @if(count($savings))
       <?php $totalsavings = 0;?>
        @foreach($savings as $saving)
        <?php $type = Savingtransaction::where('savingaccount_id',$saving->id)->pluck('type');?>
        <!-- <tr>
          @if($type == 'credit')
          <td >Deposit</td>          
          @endif
          @if($type == 'debit')
          <td >Withdrawal</td>          
          @endif
          <td  align="right">{{asMoney(Savingaccount::getMemberSaving($saving,$from,$to))}}</td>
        </tr> -->
        <?php $totalsavings = $totalsavings+Savingaccount::getMemberBalance($saving,$from,$to);
              $net = $net + $totalsavings;
        ?>
        @endforeach
          <tr >
          <td >Savings</td>
          <td >{{asMoney($totalsavings)}}</td>
          </tr>
        
        
       @endif


       @if(count($shares))
         
        <?php $totalshares = 0;?>
       @foreach($shares as $share)
       <?php $type = Sharetransaction::where('shareaccount_id',$share->id)->pluck('type');?>
        <!-- <tr>
          @if($type == 'credit')
          <td >Purchase</td>          
          @endif
          @if($type == 'debit')
          <td >Sell</td>          
          @endif
          <td align="right" >{{asMoney(Sharetransaction::getAmount($share,$from,$to))}}</td>
        </tr> -->
        <?php $totalshares = $totalshares+Sharetransaction::getBalance($share,$from,$to);
              $net = $net - $totalshares;
        ?>
        @endforeach
         <tr >
          <td >Shares</td>
          <td >{{asMoney($totalshares)}}</td>
          </tr>
       @endif

       
       @if(count($loans))
          
        <?php $totalloans = 0;?>
         @foreach($loans as $loan)
      
        <!-- <tr>
          <td >{{ $loan->loanproduct->name}}</td>          
          <td  align="right">{{asMoney(Loantransaction::getLoanAcc($loan,$from,$to))}}</td>
        </tr> -->
        <?php $totalloans = $totalloans+Loantransaction::getLoanAcc($loan,$from,$to);
              $net = $net - $totalloans;
        ?>
        @endforeach 

        <tr >
          <td >Loans</td>
          <td >{{asMoney($totalloans)}}</td>
        </tr>
        
       @endif

       
       @if(count($contributions))
          
        <?php $totalcontribution = 0;?>
        @foreach($contributions as $contribution)
        <!-- <tr>
          @if($contribution->type == 'debit')
          <td >Member Contribution</td>          
          @endif
          @if($contribution->type == 'credit')
          <td >Missed Contribution</td>          
          @endif
          <td  align="right">{{asMoney(Contribution::getContAmount($member->id,$contribution->id,$from,$to))}}</td>
        </tr> -->
        <?php
         $totalcontribution = $totalcontribution + Contribution::getContAmount($member->id,$contribution->id,$from,$to);
         $net = $net - Contribution::getContAmount($member->id,$contribution->id,$from,$to); ?>
        @endforeach
        <tr >
          <td >Office Contributions</td>
          <td >{{asMoney($totalcontribution)}}</td>
          </tr>
      
       @endif

       @if(count($tlbs))
          
        <?php $totaltlbs = 0;?>
        @foreach($tlbs as $tlb)
        <!-- <tr>
          <td >{{$tlb->regno}}</td>          
          <td  align="right">{{asMoney($tlb->amount)}}</td>
        </tr> -->
        <?php
         $totaltlbs = $totaltlbs + $tlb->amount;
         $net = $net - $tlb->amount; ?>
        @endforeach
        <tr >
          <td >Tlb Payments</td>
          <td >{{asMoney($totaltlbs)}}</td>
          </tr>
      
       @endif
      


      <tr>

        <hr>
      </tr>



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



