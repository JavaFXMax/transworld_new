@extends('layouts.savings')
@section('content')
<br/>
<?php
      function asMoney($value) {
            return number_format($value, 2);
      }
?>
<div class="row">
	<div class="col-lg-12">
  <h3>Update Deposit Product</h3>
<hr>
</div>
</div>
<div class="row">
	<div class="col-lg-5">
		 @if ($errors->has())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
        @endif
		 <form method="POST" action="{{ URL::to('savingproducts/update') }}" accept-charset="UTF-8">
    <fieldset>
      <input type="hidden" name="saving_product" value="{{$savingproduct->id}}">
        <div class="form-group">
            <label for="username">Product Name</label>
            <input class="form-control" placeholder="" type="text" name="name" id="name" value="{{{ $savingproduct->name }}}" required>
        </div>
        <div class="form-group">
            <label for="username">Product Short Name</label>
            <input class="form-control" placeholder="" type="text" name="shortname" id="shortname" value="{{{ $savingproduct->shortname }}}" required>
        </div>
         <div class="form-group">
            <label for="username">Account opening balance</label>
            <input class="form-control" placeholder="" type="text" name="opening_balance" id="opening_balance" value="{{{ $savingproduct->opening_balance}}}" required>
        </div>
        <div class="form-group">
            <label for="username">Product Type</label>
            <select class="form-control selectable" name="type" required>
                <option value="{{$savingproduct->type}}">{{$savingproduct->type}}</option>
                <option value="BOSA">BOSA</option>
                 <option value="FOSA">FOSA</option>
            </select>
        </div>
        <div class="form-actions form-group">
          <button type="submit" class="btn btn-primary btn-sm">Update Product</button>
        </div>
    </fieldset>
</form>
  </div>
</div>
@stop
