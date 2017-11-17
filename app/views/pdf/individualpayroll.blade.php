<html>
  <head>
   <style>
     @page { margin: 170px 30px; }
     .header { position: fixed; left: 0px; top: -150px; right: 0px; height: 150px;  text-align: center; }
     .footer { position: fixed; left: 0px; bottom: -180px; right: 0px; height: 50px;  }
     .footer .page:after { content: counter(page, upper-roman); }
     .content { margin-top: 0px;  }
     table {font-size:14px;}
      
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
          <strong><h3>{{'PAYROLL STATEMENT'}}</h3></strong>

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
     
     <div align="center"><strong><h2>{{$member->membership_no.' : '.$member->name.' PAYROLL STATEMENT BETWEEN '.$from.' AND '.$to}} </h2></strong></div>


      <table align="center" class="table table-bordered" style="width:40%">
        <tr>
          <td style="border-top:0.2px solid black;border-bottom:0.3px solid black; border-right:0.3px solid black;border-left:0.3px solid black;"><strong>Member Info</strong></td>
          <td style="border-top:0.3px solid black;border-bottom:0.3px solid black; border-right:0.3px solid black;"></td>
          </tr>
        <tr>
          <td style="border-bottom:0.3px solid black; border-right:0.3px solid black;border-left:0.3px solid black;">Member Number</td>
          <td style="border-bottom:0.3px solid black; border-right:0.3px solid black;">{{$member->membership_no}}</td>
        </tr>
        <tr>
          <td style="border-bottom:0.3px solid black; border-right:0.3px solid black;border-left:0.3px solid black;">Member Name</td>
          <td style="border-bottom:0.3px solid black; border-right:0.3px solid black;">{{$member->name}}</td>
        </tr>
         
       <?php $net = 0;?>
       @if(count($savings))
       <?php $totalsavings = 0;?>
        @foreach($savings as $saving)
        <?php $type = Savingtransaction::where('savingaccount_id',$saving->id)->pluck('type');?>
        <!-- <tr>
          @if($type == 'credit')
          <td style="border-bottom:0.3px solid black; border-right:0.3px solid black;border-left:0.3px solid black;">Deposit</td>          
          @endif
          @if($type == 'debit')
          <td style="border-bottom:0.3px solid black; border-right:0.3px solid black;border-left:0.3px solid black;">Withdrawal</td>          
          @endif
          <td style="border-bottom:0.3px solid black; border-right:0.3px solid black;" align="right">{{asMoney(Savingaccount::getMemberSaving($saving,$from,$to))}}</td>
        </tr> -->
        <?php $totalsavings = $totalsavings+Savingaccount::getMemberBalance($saving,$from,$to);
              $net = $net + $totalsavings;
        ?>
        @endforeach
          <tr>
          <td style="border-bottom:0.3px solid black; border-right:0.3px solid black;border-left:0.3px solid black;">Savings</td>
          <td style="border-bottom:0.3px solid black; border-right:0.3px solid black;">{{asMoney($totalsavings)}}</td>
          </tr>
        
        
       @endif


       @if(count($shares))
         
        <?php $totalshares = 0;?>
       @foreach($shares as $share)
       <?php $type = Sharetransaction::where('shareaccount_id',$share->id)->pluck('type');?>
        <!-- <tr>
          @if($type == 'credit')
          <td style="border-bottom:0.3px solid black; border-right:0.3px solid black;border-left:0.3px solid black;">Purchase</td>          
          @endif
          @if($type == 'debit')
          <td style="border-bottom:0.3px solid black; border-right:0.3px solid black;border-left:0.3px solid black;">Sell</td>          
          @endif
          <td align="right" style="border-bottom:0.3px solid black; border-right:0.3px solid black;">{{asMoney(Sharetransaction::getAmount($share,$from,$to))}}</td>
        </tr> -->
        <?php $totalshares = $totalshares+Sharetransaction::getBalance($share,$from,$to);
              $net = $net - $totalshares;
        ?>
        @endforeach
         <tr>
          <td style="border-bottom:0.3px solid black; border-right:0.3px solid black;border-left:0.3px solid black;">Shares</td>
          <td style="border-bottom:0.3px solid black; border-right:0.3px solid black;">{{asMoney($totalshares)}}</td>
          </tr>
       @endif

       
       @if(count($loans))
          
        <?php $totalloans = 0;?>
         @foreach($loans as $loan)
      
        <!-- <tr>
          <td style="border-bottom:0.3px solid black; border-right:0.3px solid black;border-left:0.3px solid black;">{{ $loan->loanproduct->name}}</td>          
          <td style="border-bottom:0.3px solid black; border-right:0.3px solid black;" align="right">{{asMoney(Loantransaction::getLoanAcc($loan,$from,$to))}}</td>
        </tr> -->
        <?php $totalloans = $totalloans+Loantransaction::getLoanAcc($loan,$from,$to);
              $net = $net - $totalloans;
        ?>
        @endforeach 

        <tr>
          <td style="border-bottom:0.3px solid black; border-right:0.3px solid black;border-left:0.3px solid black;">Loans</td>
          <td style="border-bottom:0.3px solid black; border-right:0.3px solid black;">{{asMoney($totalloans)}}</td>
        </tr>
        
       @endif

       
       @if(count($contributions))
          
        <?php $totalcontribution = 0;?>
        @foreach($contributions as $contribution)
        <!-- <tr>
          @if($contribution->type == 'debit')
          <td style="border-bottom:0.3px solid black; border-right:0.3px solid black;border-left:0.3px solid black;">Member Contribution</td>          
          @endif
          @if($contribution->type == 'credit')
          <td style="border-bottom:0.3px solid black; border-right:0.3px solid black;border-left:0.3px solid black;">Missed Contribution</td>          
          @endif
          <td style="border-bottom:0.3px solid black; border-right:0.3px solid black;" align="right">{{asMoney(Contribution::getContAmount($member->id,$contribution->id,$from,$to))}}</td>
        </tr> -->
        <?php
         $totalcontribution = $totalcontribution + Contribution::getContAmount($member->id,$contribution->id,$from,$to);
         $net = $net - Contribution::getContAmount($member->id,$contribution->id,$from,$to); ?>
        @endforeach
        <tr>
          <td style="border-bottom:0.3px solid black; border-right:0.3px solid black;border-left:0.3px solid black;">Office Contributions</td>
          <td style="border-bottom:0.3px solid black; border-right:0.3px solid black;">{{asMoney($totalcontribution)}}</td>
          </tr>
      
       @endif

       @if(count($tlbs))
          
        <?php $totaltlbs = 0;?>
        @foreach($tlbs as $tlb)
        <!-- <tr>
          <td style="border-bottom:0.3px solid black; border-right:0.3px solid black;border-left:0.3px solid black;">{{$tlb->regno}}</td>          
          <td style="border-bottom:0.3px solid black; border-right:0.3px solid black;" align="right">{{asMoney($tlb->amount)}}</td>
        </tr> -->
        <?php
         $totaltlbs = $totaltlbs + $tlb->amount;
         $net = $net - $tlb->amount; ?>
        @endforeach
        <tr>
          <td style="border-bottom:0.3px solid black; border-right:0.3px solid black;border-left:0.3px solid black;">Tlb Payments</td>
          <td style="border-bottom:0.3px solid black; border-right:0.3px solid black;">{{asMoney($totaltlbs)}}</td>
          </tr>
      
       @endif

          
          </table>
    
   </div>


 </body>
 </html>