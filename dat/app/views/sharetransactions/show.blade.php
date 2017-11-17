@extends('layouts.member')
@section('content')
<br/>
<?php
    function asMoney($value) {
      return number_format($value, 2);
    }
?>
<div class="row">
      	<div class="col-lg-5">
               <table class="table table-condensed table-bordered table-hover">
                    <tr>
                        <td>Member Name</td><td>{{ $account->member->name}}</td>
                    </tr>
                    <tr>
                        <td>Member Number</td><td>{{ $account->member->membership_no}}</td>
                    </tr>
                    <tr>
                        <td>Account Number</td><td>{{ $account->account_number}}</td>
                    </tr>
               </table>
      </div>
      <div class="col-lg-5 col-lg-offset-2">
          <table class="table table-condensed table-bordered table-hover">
                 <tr>
                     <td>Share Capital</td><td>{{ asMoney($share_capital)}}</td>
                 </tr>
                 <tr>
                     <td>Share Deposits</td><td>{{asMoney($others)}}</td>
                 </tr>
                 <tr>
                     <td>Membership Fee</td><td>{{ asMoney($membership) }}</td>
                 </tr>
                 <tr>
                     <td>Petrol Investment</td><td>{{ asMoney($petrol) }}</td>
                 </tr>
          </table>
      </div>
</div>
<div class="row">
	<div class="col-lg-12">
		 <hr>
  </div>
</div>
<div class="row">
            <div class="col-lg-12">
                       <div class="panel panel-default">
                          <div class="panel-heading">
                              <a class="btn btn-info btn-sm" href="{{ URL::to('sharetransactions/create/'.$account->id)}}">
                                 New Transaction
                               </a>
                          </div>
                          <div class="panel-body">
                              <table id="users" class="table table-condensed table-striped table-responsive table-hover">
                                <thead>
                                  <th>Date</th>
                                  <th>Description</th>
                                  <th>Debit (DR)</th>
                                   <th>Credit (CR)</th>
                                </thead>
                                <tbody>
                                  @foreach($account->sharetransactions as $transaction)
                                      @if($transaction->amount != 0)
                                          <tr>
                                            <td>{{ $transaction->date }}</td>
                                            @if($transaction->pay_for == 'shares')
                                            <td>Share Capital Payment</td>
                                            @endif
                                            @if($transaction->pay_for == 'membership')
                                            <td>Membership Fee Payment</td>
                                            @endif
                                            @if($transaction->pay_for == 'petrol')
                                            <td>Petrol Station Investment</td>
                                            @endif
                                            @if($transaction->pay_for == 'others')
                                            <td>{{ $transaction->description }}</td>
                                            @endif
                                            @if( $transaction->type == 'debit')
                                            <td >{{ asMoney($transaction->amount)}}</td>
                                            <td>0.00</td>
                                            @endif
                                            @if( $transaction->type == 'credit' )
                                                 <td>0.00</td>
                                                <td>{{ asMoney($transaction->amount) }}</td>
                                          @endif
                                          </tr>
                                      @endif
                                  @endforeach
                                </tbody>
                              </table>
                        </div>
              </div>
</div>
@stop
