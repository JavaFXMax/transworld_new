<?php
function asMoney($value) {
  return number_format($value, 2);
}
?>
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body style="font-size: 12px;">
     <table>
      <tr>
        <th style="width:150px">
             <img src="{{ asset('public/uploads/logo/'.$organization->logo ) }}" alt="{{ $organization->logo }}" width="150px" height="150px"/>
        </th>
        <th>
        <strong>
          {{ strtoupper($organization->name)}}<br>
          </strong>
          {{ $organization->phone}}<br>
          &nbsp; {{ $organization->email}} <br>
          &nbsp; {{ $organization->website}}<br>
          &nbsp; {{ $organization->address}}
        </th>
      </tr>
    </table>
    <br><br><br>
    <table border="1">
      <tr>
        <td><strong># </strong></td>
        <td><strong>Member Number </strong></td>
        <td><strong>Member Name </strong></td>
        <td><strong>Member Group </strong></td>
        <td><strong>Member Branch </strong></td>
      </tr>
<?php $i =1; ?>
      @foreach($members as $member)
      <tr>
       <td>{{$i}}</td>
        <td>{{$member->membership_no}}</td>
        <td> {{ $member->name}}</td>
        @if($member->group != null)
        <td> {{ $member->group->name}}</td>
        @else
        <td></td>
        @endif
        @if($member->branch != null)
        <td> {{ $member->branch->name}}</td>
        @else
        <td></td>
        @endif
      </tr>
      <?php $i++; ?>
    @endforeach
    </table>
<br><br>
</body>
</html>
