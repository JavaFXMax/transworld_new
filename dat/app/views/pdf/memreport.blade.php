@extends('layouts.ports')
@section('content')

<?php


function asMoney($value) {
  return number_format($value, 2);
}

?>

<br><br>
		
										<div class="row">
											<div class="col-lg-5">

												<form method="post" target="_blank" action="{{URL::to('report/memberstatements')}}">
													
										        <div class="form-group">
                                                   <label for="username">Member <span style="color:red">*</span></label>
                                                     <select name="member_id" class="form-control" data-live-search="true">
                                                        <option></option>
                                                          @foreach($members as $member)
                                                          <option value="{{ $member->id }}"> {{ $member->name }}</option>
                                                          @endforeach
                                                      </select>
                
                                                </div>    

												
											    <div class="form-actions form-group">
        
                                                  <button type="submit" class="btn btn-primary btn-sm">Select Member</button>
                                                </div>

												</form>
												
											</div>

											
											

											


											
											
										</div>
									







@stop
