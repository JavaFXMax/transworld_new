<?php
function asMoney($value) {
  return number_format($value, 2);
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Yellow Berries</title>
  </head>
  <body>
    <table>
      <tr>
        <th>Name</th>
        <th>Name</th>
        <th>Name</th>
        <th>Name</th>
      </tr>
        <tr>
          <td>{{$organization->name}}</td>
          <td>{{$organization->name}}</td>
          <td>{{$organization->name}}</td>
          <td>{{$organization->name}}</td>
        </tr>
    </table>
    <hr>
    <table class="table table-bordered" style="width:100%">
        <tr style="font-weight:bold">
            <th>#</th>
            <th>Member</th>
            <th>Member #</th>
            <th>Total Contributions</th>
            <th>Accrued Dividends</th>
        </tr>
        <tbody>
         <?php $i =1; ?>
          @foreach($members as $member)
           <tr>
              <td>{{$i}}</td>
              <td>{{ucwords($member->name)}}</td>
              <td>{{ucwords($member->membership_no)}}</td>
              <?php
                $contributions=Savingtransaction::where('savingaccount_id','=',$member->id)
                        ->where('type','=', 'credit')->sum('amount');
              ?>
              <td>{{asMoney($contributions)}}</td>
              <td>{{asMoney($contributions/40)}}</td>
            </tr>
             <?php $i++; ?>
          @endforeach
        </tbody>
    </table>
  </body>
</html>
