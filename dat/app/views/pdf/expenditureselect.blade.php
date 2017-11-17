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

												<form method="post" target="_blank" action="{{URL::to('reports/expenseincome')}}">
													
										        <div class="form-group">
                                                   <label for="username">Vehicle <span style="color:red">*</span></label>
                                                     <select required name="vehicle_id" class="form-control" data-live-search="true">
                                                        <option></option>
                                                        <option ="All">All</option>
                                                          @foreach($vehicles as $vehicle)
                                                          <option value="{{ $vehicle->id }}"> {{ $vehicle->make.' - '.$vehicle->regno }}</option>
                                                          @endforeach
                                                      </select>
                
                                                </div>    

                                                <div class="form-group">
                                                  <label for="username">Type </label>
                                                    <select required name="type" class="form-control" required>
                                                      <option></option>
                                                      <option value="All">All</option>
                                                      <option value="Income"> Income</option>
                                                      <option value="Expense"> Expense</option>
                                                    </select>
                                                </div>  

                                                <div class="form-group">
                        <label for="username">From <span style="color:red">*</span></label>
                        <div class="right-inner-addon ">
                        <i class="glyphicon glyphicon-calendar"></i>
                        <input required class="form-control datepicker" readonly="readonly" placeholder="" type="text" name="from" id="from" value="{{{ Input::old('from') }}}">
                    </div>
       </div>


       <div class="form-group">
                        <label for="username">To <span style="color:red">*</span></label>
                        <div class="right-inner-addon ">
                        <i class="glyphicon glyphicon-calendar"></i>
                        <input required class="form-control datepicker" readonly="readonly" placeholder="" type="text" name="to" id="to" value="{{{ Input::old('to') }}}">
                    </div>
       </div>


												
											    <div class="form-actions form-group">
        
                                                  <button type="submit" class="btn btn-primary btn-sm">Select Member</button>
                                                </div>

												</form>
												
											</div>

											
											

											


											
											
										</div>
									







@stop
