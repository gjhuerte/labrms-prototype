@extends('layouts.master-blue')
@section('title')
Inventory Addition
@stop
@section('navbar')
@include('layouts.navbar.admin.default')
@stop
@section('style')
{{ HTML::style(asset('css/jquery-ui.min.css')) }}
<style>
	#page-body{
		display: none;
	}

	#podate, #invoicedate, #model{
		background-color: white;
	}
</style>
@stop
@section('script-include')
{{ HTML::script(asset('js/jquery-ui.js')) }}
@stop
@section('content')
<div class="container-fluid" id="page-body">
	<div class='col-md-12'>
		<div class="col-md-offset-3 col-md-6 panel panel-body">
	      @if (count($errors) > 0)
         	 <div class="alert alert-danger alert-dismissible" role="alert">
	          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	              <ul style='margin-left: 10px;'>
	                  @foreach ($errors->all() as $error)
	                      <li>{{ $error }}</li>
	                  @endforeach
	              </ul>
	          </div>
	      @endif
			{{ Form::open(['method'=>'post','route'=>'inventory.item.store','class'=>'form-horizontal','id'=>'inventoryAdditionForm']) }}
				<ol class="breadcrumb" style="background-color: white;">
				  <li><a href="{{ url('inventory/item') }}">Inventory</a></li>
				  <li><a href="{{ url('inventory/item') }}">Item</a></li>
				  <li class="active">{{ $inventory->id }}</li>
				  <li class="active">Add</li>
				</ol>
			<div class="panel panel-body">
        <div class="form-group">
          <div class="col-md-12">
	          <label>Model</label>
						<input type="text" val="" id="model" class="form-control" readonly disabled />
          </div>
        </div>
        {{ Form::hidden('id',Input::old('id')) }}
        <div class="form-group">
          <div class="col-md-12">
          {{ Form::label('number','Receipt details ( M.R., Acknowledgement )') }}
          {{ Form::text('number',Input::old('receipt'),[
              'class' => 'form-control'
            ]) }}
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12">
          {{ Form::label('quantity','Quantity') }}
          {{ Form::number('quantity',Input::old('quantity'),[
              'class' => 'form-control'
            ]) }}
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12">
          {{ Form::label('ponumber','P.O. Number') }}
          {{ Form::number('ponumber',Input::old('ponumber'),[
            'class' => 'form-control',
            'placeholder' => 'P.O. Number',
            'id' => 'ponumber'
          ]) }}
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12">
          {{ Form::label('podate','P.O. Date') }}
          {{ Form::text('podate',Input::old('podate'),[
						'id' => 'podate',
            'class' => 'form-control',
            'placeholder' => 'P.O. Date',
            'readonly'
          ]) }}
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12">
          {{ Form::label('invoicenumber','Invoice Number') }}
          {{ Form::number('invoicenumber',Input::old('invoicenumber'),[
            'class' => 'form-control',
            'placeholder' => 'P.O. Number',
            'id' => 'ponumber'
          ]) }}
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12">
          {{ Form::label('invoicedate','Invoice Date') }}
          {{ Form::text('invoicedate',Input::old('invoicedate'),[
						'id' => 'invoicedate',
            'class' => 'form-control',
            'placeholder' => 'Invoice Date',
            'readonly'
          ]) }}
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12">
          {{ Form::label('fundcode','Fund Code') }}
          {{ Form::text('fundcode',Input::old('fundcode'),[
            'class' => 'form-control',
            'placeholder' => 'Fund Code',
            'id' => 'fundcode'
          ])}}
          </div>
        </div>
        <div class="form-group">
					<div class="col-md-12">
		          <button type="submit" class="btn btn-success btn-block btn-lg" name='action' value='add'>Add</button>
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

		$('#model').val('{{ $inventory->model }}');

		$( "#podate" ).datepicker({
			  changeMonth: true,
			  changeYear: false,
			  maxAge: 59,
			  minAge: 15
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
		$('#page-body').show();
	});
</script>
@stop
