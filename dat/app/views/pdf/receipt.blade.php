<?php


function asMoney($value) {
  return number_format($value, 2);
}

?>
<html >



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



</style>

</head>



<div class="row">



	<div class="col-lg-8">


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


       
        <td>Member:</td><td> {{ $transaction->savingaccount->member->name}}</td>
      </tr>
      <tr>

        <td>Member #:</td><td> {{ $transaction->savingaccount->member->membership_no}}</td>

        </tr>
      <tr>
        
        <td>Account :</td><td> {{ $transaction->savingaccount->account_number}}</td>

      </tr>

      <tr>
        
        <td>Account Balance:</td><td> {{ asMoney(Savingaccount::getAccountBalance($transaction->savingaccount))}}</td>

      </tr>


      <tr>
        
        <td>Branch :</td><td> {{ $transaction->savingaccount->member->branch->name}}</td>

      </tr>


      <tr>

        <hr>
      </tr>



    </table>

<br><br>

     <table class="table table-bordered">


      <tr>

        <td> <strong> Date </strong></td>
        <td> <strong> Description </strong></td>
        <td><strong> Amount </strong></td>

      </tr>

      <tr>

        <td>{{ $transaction->date }}</td>
        <td>{{ $transaction->description }}</td>
        <td>{{ asMoney($transaction->amount )}}</td>
       
        
      </tr>
      


      <tr>

        <hr>
      </tr>



    </table>


<br><br>

     <table class="table table-bordered">
      <tr>

        <td style="width:80px;"> Transacted By </td>
        <td>  {{$transaction->transacted_by}} </td>
        

      </tr>


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



