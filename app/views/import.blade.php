@extends('layouts.system')
@section('content')
<br/><br/>

<div class="row">
	<div class="col-lg-1">



</div>	

<div class="col-lg-12">

	@if (Session::get('error'))
            <div class="alert alert-danger">{{{ Session::get('error') }}}</div>
        @endif

        @if (Session::get('notice'))
            <div class="alert alert-info">{{{ Session::get('notice') }}}</div>
        @endif




</div>	


<div class="col-lg-5 ">

<p>Bulk Import Savings</p>
<hr>
<form method="POST" action="{{{ URL::to('import/savings') }}}"  enctype="multipart/form-data">
 


		<div class="form-group">
            <label for="username">File  </label>
            <input type="file" name="savings" id="savings" >
        </div>

        <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm">Upload & Import</button>
        </div>


</form>	

</div>	




<div class="col-lg-5 ">

<p>Bulk Import Loans</p>
<hr>
<form method="POST" action="{{{ URL::to('import/loans') }}}"  enctype="multipart/form-data">
 


        <div class="form-group">
            <label for="username">File </label>
            <input type="file" name="loans" id="loans" >
        </div>

        <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm">Upload & Import</button>
        </div>


</form> 

</div> 



<div class="col-lg-5 ">
<br>
<p>Bulk Import Loan repayments</p>
<hr>
<form method="POST" action="{{{ URL::to('import/repayments') }}}"  enctype="multipart/form-data">
 


        <div class="form-group">
            <label for="username">File </label>
            <input type="file" name="repayments" id="repayments" >
        </div>

        <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm">Upload & Import</button>
        </div>


</form> 

</div>  



</div>


@stop