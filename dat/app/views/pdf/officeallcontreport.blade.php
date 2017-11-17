<html>
  <head>
     
   <style>
     @page { margin: 30px; }
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
          <strong><h3>MEMBER CONTRIBUTIONS STATEMENT </h3></strong>

        </td>
        

      </tr>


      <tr>

        <hr>
      </tr>



    </table>
    <br><br>
     
      <table class="table table-bordered" style="width:60%">

          

         <tr>
            <td>Period:</td><td>{{$from.' to '.$to}}</td>

          </tr>


      </table>
      <br><br>
      


      <table class="table table-bordered" style="width:100%">



          <tr style="font-weight:bold">
              <td>Date</td>
              <td>Member #</td>
              <td>Member</td>
              <?php if($desc == 'all'){?>
              <td>Debit(Member Contributions)</td>
              <td>Credit(Missed Contributions)</td>
              <?php }else if($desc == 'debit'){?>
              <td>Description</td>
              <td>Debit(Dr)</td>
              <?php }else if($desc == 'credit'){?>
              <td>Description</td>
              <td>Reason</td>
              <td>Credit(Cr)</td>
              <?php }?>
              
          </tr>

          <tbody>
         

           
             <?php
              $credit = 0;
              $debit  = 0;
             ?>

            <?php if($desc == 'all'){?>
             @foreach($contributions as $transaction)
          <tr>

         
          <td>{{ $transaction->date }}</td>
          <td>{{ucwords(Member::getMemberNo($transaction->member_id))}}</td>
          <td>{{ucwords(Member::getMemberName($transaction->member_id))}}</td>
          
           
          <td >{{ asMoney(Contribution::debittotal($transaction->member_id,$from,$to))}}</td>
         
          <?php 
           $debit = $debit + Contribution::debittotal($transaction->member_id,$from,$to);
          ?>

          <td>{{ asMoney(Contribution::credittotal($transaction->member_id,$from,$to)) }}</td>
          <?php 
           $credit = $credit + Contribution::credittotal($transaction->member_id,$from,$to);
          ?>

        
        </tr>

       
        @endforeach
        <?php }else if($desc == 'debit'){?>
        @foreach($paid as $transaction)
          <tr>

         
          <td>{{ $transaction->date }}</td>
          <td>{{ucwords(Member::getMemberNo($transaction->member_id))}}</td>
          <td>{{ucwords(Member::getMemberName($transaction->member_id))}}</td>
          
           @if( $transaction->type == 'debit')
          <td >member contribution</td>
          @endif

          @if( $transaction->type == 'debit')
          <td >{{ asMoney(Contribution::debittotal($transaction->member_id,$from,$to))}}</td>
        
          <?php 
           $debit = $debit + Contribution::debittotal($transaction->member_id,$from,$to);
          ?>
          @endif

        
        </tr>

       
        @endforeach
        <?php }else if($desc == 'credit'){?>
        @foreach($missed as $transaction)
          <tr>

         
          <td>{{ $transaction->date }}</td>
          <td>{{ucwords(Member::getMemberNo($transaction->member_id))}}</td>
          <td>{{ucwords(Member::getMemberName($transaction->member_id))}}</td>
          
      
          @if( $transaction->type == 'credit')
          <td >contribution missed</td>
          @endif
  
          <td >{{$transaction->reason}}</td>
       @if( $transaction->type == 'credit')
     
          <td>{{ asMoney(Contribution::credittotal($transaction->member_id,$from,$to)) }}</td>
          <?php 
           $credit = $credit + Contribution::credittotal($transaction->member_id,$from,$to);
          ?>
          @endif

        
        </tr>

       
        @endforeach
        <?php } ?>

        <?php if($desc == 'all'){?>
         <tr><td colspan="3" align="right"><strong>Total</strong></td><td><strong>{{asMoney($debit)}}</strong></td><td><strong>{{asMoney($credit)}}</strong></td></tr>
        <?php }else if($desc == 'debit'){?>
        <tr><td colspan="4" align="right"><strong>Total</strong></td><td><strong>{{asMoney($debit)}}</strong></td></tr>
        <?php }else if($desc == 'credit'){?>   
        <tr><td colspan="5" align="right"><strong>Total</strong></td><td><strong>{{asMoney($credit)}}</strong></td></tr>
        <?php } ?>
          
               



          </tbody>
      </table>















    
   </div>








 </body>
 </html>