@extends('layouts.master-blue')
@section('title')
Inventory
@stop
@section('navbar')
@include('layouts.navbar.admin.default')
@stop
@section('style')
{{ HTML::style(asset('css/jquery-ui.min.css')) }}
<style>
	#inventory,#page-body{
		display:none;
	}

	#podate,#invoicedate{
		background-color:white;
	}
	
</style>
@stop
@section('script-include')
{{ HTML::script(asset('js/jquery-ui.js')) }}	
@stop
@section('content')
<div class="container-fluid" id="page-body">
	<div class='col-md-offset-3 col-md-6'>  
		<ol class="breadcrumb" style="background-color: white;">
		  <li><a href="{{ url('inventory/item') }}">Inventory</a></li>
		  <li><a href="{{ url('inventory/item') }}">Item</a></li>
		  <li class="active">Create</li>
		</ol>   
		<div class="panel panel-body" style="padding-top: 20px;padding-left: 40px;padding-right: 40px;">
	      @if (count($errors) > 0)
         	 <div class="alert alert-danger alert-dismissible" role="alert">
	          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	              <ul class="list-unstyled" style='margin-left: 10px;'>
	                  @foreach ($errors->all() as $error)
	                      <li class="text-capitalize">{{ $error }}</li>
	                  @endforeach
	              </ul>
	          </div>
	      @endif
	 		{{ Form::open(['method'=>'post','route'=>'inventory.item.store','class'=>'form-horizontal','id'=>'ticketingForm']) }}
	 		<div id="receipt">
				<legend><h3 style="color:#337ab7;">Receipt</h3></legend>
					<!-- item name -->
					<div class="form-group">
						<div class="col-sm-12">
						{{ Form::label('number','Acknowledgement Receipt ( M.R., P.A.R. )') }}
						{{ Form::text('number',Input::old('number'),[
							'class' => 'form-control',
							'placeholder' => 'Acknowledgement Receipt',
							'id' => 'number'
						]) }}
						</div>	
					</div>
					<div class="form-group">
						<div class="col-sm-12">
						{{ Form::label('ponumber','P.O. Number') }}
						{{ Form::number('ponumber',Input::old('ponumber'),[
							'class' => 'form-control',
							'placeholder' => 'P.O. Number',
							'id' => 'ponumber'
						]) }}
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
						{{ Form::label('podate','P.O. Date') }}
						{{ Form::text('podate',Input::old('podate'),[
							'class' => 'form-control',
							'placeholder' => 'P.O. Date',
							'id' => 'podate',
							'readonly'
						]) }}
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
						{{ Form::label('invoicenumber','Invoice Number') }}
						{{ Form::number('invoicenumber',Input::old('invoicenumber'),[
							'class' => 'form-control',
							'placeholder' => 'P.O. Number',
							'id' => 'ponumber'
						]) }}
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
						{{ Form::label('invoicedate','P.O. Date') }}
						{{ Form::text('invoicedate',Input::old('invoicedate'),[
							'class' => 'form-control',
							'placeholder' => 'Invoice Date',
							'id' => 'invoicedate',
							'readonly'
						]) }}
						</div>
					</div>
					<div class="form-group">	
						<div class="col-sm-12">
						{{ Form::label('fundcode','Fund Code') }}
						{{ Form::text('fundcode',Input::old('fundcode'),[
							'class' => 'form-control',
							'placeholder' => 'Fund Code',
							'id' => 'fundcode'
						]) }}
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-8 col-sm-4">
							<button name="next" id="link-to-inventory" class="btn btn-primary btn-block" type="button">Next <span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span></button>
						</div>
					</div>
	 		</div>
	 		<div id="inventory">
				<legend><h3 style="color:#337ab7;">Inventory</h3></legend>
				<div id="page-one">
					<!-- item name -->
					<div class="form-group">
						<div class="col-sm-12">
						{{ Form::label('brand','Brand') }}
						{{ Form::text('brand',Input::old('brand'),[
							'class' => 'form-control',
							'placeholder' => 'Brand',
							'id' => 'brand'
						]) }}
						</div>	
					</div>
					<div class="form-group">
						<div class="col-sm-12">
						{{ Form::label('model','Model') }}
						{{ Form::text('model',Input::old('model'),[
							'class' => 'form-control',
							'placeholder' => 'Model',
							'id' => 'model'
						]) }}
						</div>
					</div>
					<div class="form-group">	
						<div class="col-sm-12">
						{{ Form::label('itemtype','Type') }}
						{{ Form::text('itemtype',Input::old('itemtype'),[
							'class' => 'form-control',
							'placeholder' => 'Item type',
							'id' => 'itemtype'
						]) }}
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
						{{ Form::label('details','Item Details') }}
						{{ Form::textarea('details',Input::old('details'),[
							'class' => 'form-control',
							'placeholder' => 'Warranty Information',
							'id' => 'details'
						]) }}
						</div>
					</div>	
					<div class="form-group">
						<div class="col-sm-offset-4 col-sm-4">
							<button name="next" id="next" class="btn btn-primary btn-block" type="button">Next <span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span></button>
						</div>
						<div class="col-sm-4">
							<button name="previous" id="link-to-receipt" class="btn btn-info btn-block" type="button"> <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Previous</button>
						</div>
					</div>
				</div>
				<div id="page-two">
					<div class="form-group">		
						<div class="col-sm-12">
						{{ Form::label('unit','Unit') }}
						{{ Form::text('unit',Input::old('unit'),[
							'class' => 'form-control',
							'placeholder' => 'Unit'
						]) }}
						</div>	
					</div>
					<div class="form-group">
						<div class="col-sm-12">
						{{ Form::label('quantity','Quantity') }}
						{{ Form::number('quantity',Input::old('quantity'),[
							'class' => 'form-control',
							'placeholder' => 'Quantity'
						]) }}
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
						{{ Form::label('warranty','Warranty Information') }}
						{{ Form::textarea('warranty',Input::old('warranty'),[
							'class' => 'form-control',
							'placeholder' => 'Warranty Information',
							'id' => 'warranty'
						]) }}
						</div>
					</div>	
					<div class="form-group">
						<div class="col-sm-offset-4 col-sm-4">
							<button name="submit" id="submit" class="btn btn-primary btn-block" type="submit" data-loading-text="Submitting..." class="btn btn-primary" autocomplete="off"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Submit </button>
						</div>
						<div class="col-sm-4">
							<button name="previous" id="previous" class="btn btn-info btn-block" type="button"> <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Previous</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop
@section('script')
<script type="text/javascript">
	$(document).ready(function(){
		$('#link-to-inventory').click(function(){
			$('#page-two').hide(600);
			$('#receipt').hide(600);
			$('#inventory').show();
			$('#page-one').show(600);
		});

		$('#link-to-receipt').click(function(){
			$('#inventory').hide(600);
			$('#receipt').show(600);
		});

		$('#next').click(function(){
			$('#page-one').hide(600);
			$('#page-two').show(600);
		});

		$('#previous').click(function(){
			$('#page-two').hide(600);
			$('#page-one').show(600);
		});

		$( "#podate" ).datepicker({
			  changeMonth: true,
			  changeYear: false,
			  maxAge: 59,
			  minAge: 15,
		});

		$( "#invoicedate" ).datepicker({
			  changeMonth: true,
			  changeYear: false,
			  maxAge: 59,
			  minAge: 15,
		});

		@if( Session::has("success-message") )
			swal("Success!","{{ Session::pull('success-message') }}","success");
		@endif

		@if( Session::has("error-message") )
			swal("Oops...","{{ Session::pull('error-message') }}","error");
		@endif

		$('#submit').on('click', function () {
			var $btn = $(this).button('loading')
		});

		$('#page-body').show();
	})
</script>
@stop