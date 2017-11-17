@extends('layouts.ports')
@section('content')
<br/>
<div class="row">
				<div class="col-lg-12">
				  <h3> Member Petrol Station Investment Report </h3>
					<hr>
			</div>
</div>
<div class="row">
				<div class="col-md-6 col-lg-6">
					   <form method="post" target="blank" action="{{URL::to('reports/member/petrol_statement')}}">
						      <div class="form-group">
						            <label for="username">Member <span style="color:red">*</span></label>
						            <select class="form-control selectable" name="member_id">
						                <option value="">Select Member</option>
						                @foreach($members as $member)
						                <option value="{{$member->id}}">{{$member->membership_no}}&emsp; {{ ucwords($member->name)}}</option>
						                @endforeach
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
					          <button type="submit" class="btn btn-primary btn-sm">View Report</button>
					        </div>
					   </form>
			  </div>
</div>
@stop
