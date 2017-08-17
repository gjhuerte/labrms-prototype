@extends('layouts.master-blue')
@section('title')
Inventory | Create
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
{{ HTML::style(asset('css/style.css')) }}
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
	 		{{ Form::open(['method'=>'post','route'=>'inventory.item.store','class'=>'form-horizontal','id'=>'inventoryForm']) }}
			<ul class="breadcrumb">
				<li><a href="{{ url('inventory/item') }}">Item Inventory</a></li>
				<li class="active">Create</li>
			</ul>
	 		<div id="receipt">
				<legend><h3 style="color:#337ab7;">Receipt</h3></legend>
					<!-- item name -->
					<div class="form-group">
						<div class="col-sm-12">
						{{ Form::label('number','Receipt') }}
						{{ Form::text('number',Input::old('number'),[
							'class' => 'form-control',
							'placeholder' => 'Receipt',
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
						{{ Form::label('invoicedate','Invoice Date') }}
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
							<button name="next" id="link-to-inventory" class="btn btn-primary btn-flat btn-block" type="button">Next <span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span></button>
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
						{{ Form::select('itemtype',['Fetching all item types...'],Input::old('itemtype'),[
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
							'placeholder' => 'Item Details',
							'id' => 'details'
						]) }}
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-4 col-sm-4">
							<button name="previous" id="link-to-receipt" class="btn btn-default btn-flat btn-block" type="button"> <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Previous</button>
						</div>
						<div class="col-sm-4">
							<button name="next" id="next" class="btn btn-primary btn-flat btn-block" type="button">Next <span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span></button>
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
							<button name="previous" id="previous" class="btn btn-default btn-flat btn-block" type="button"> <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Previous</button>
						</div>
						<div class="col-sm-4">
							<button type="submit" value="create" name="action" id="submit" class="btn btn-primary btn-flat btn-block"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Submit </button>
						</div>
					</div>
				</div>
			</div>
			{{ Form::close() }}
		</div>
	</div>
</div>
@stop
@section('script')
{{ HTML::script(asset('js/moment.min.js')) }}
<script type="text/javascript">
	$(document).ready(function(){
		$('#brand').on('change',function(){
			setValue()
		});
		$('#itemtype').on('change',function(){
			setValue()
		});
		$('#model').on('change',function(){
			setValue()
		});

		function setValue()
		{
			url = "{{ url('get') }}" + '/' + $('#itemtype').val() + '/' + $('#brand').val() + '/' + $('#model').val()
			$.getJSON(url,function(response){
				console.log(response)
				if(response != 'error')
				{
					$('#details').val(response.details)
					$('#unit').val(response.unit)
					$('#warranty').val(response.warranty)
				} else {
					$('#details').val("")
					$('#details').removeProp("readonly")
					$('#unit').val("")
					$('#unit').removeProp("readonly")
					$('#warranty').val("")
					$('#warranty').removeProp("readonly")
				}
			})
		}

		$('#brand').autocomplete({
			source: "{{ url('get/inventory/item/brand') }}"
		})

		$('#model').autocomplete({
			source: "{{ url('get/inventory/item/model') }}"
		})

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

		init();

		function init(){
			$.ajax({
				type: "get",
				url: "{{ url('get/inventory/item/type/equipment') }}",
				dataType: 'json',
				success: function(response){
					var options = "";

					for(var ctr = 0;ctr < response.length;ctr++)
					{
						options += `<option value="`+response[ctr].id+`">
							`+response[ctr].name+`
						</option>`;
					}

					$('#itemtype').html("");
					$('#itemtype').append(options);
					@if(Input::old('itemtype'))
					$('#itemtype').val("{{ Input::old('itemtype') }}")
					@endif
				}
			})
		}

		@if(Input::old('podate'))
			$('#podate').val('{{ Input::old('podate') }}');
			setDate("#podate");
		@else
			$('#podate').val({{ "'".Carbon\Carbon::now()->toFormattedDateString()."'" }});
			setDate("#podate");
		@endif

		$('#podate').on('change',function(){
			setDate("#podate");
		});

		@if(Input::old('invoicedate'))
			$('#invoicedate').val('{{ Input::old('invoicedate') }}');
			setDate("#invoicedate");
		@else
			$('#invoicedate').val({{ "'".Carbon\Carbon::now()->toFormattedDateString()."'" }});
			setDate("#invoicedate");
		@endif

		$('#invoicedate').on('change',function(){
			setDate("#invoicedate");
		});

		function setDate(object){
				var object_val = $(object).val()
				var date = moment(object_val).format('MMM DD, YYYY');
				$(object).val(date);
		}

		@if( Session::has("success-message") )
			swal("Success!","{{ Session::pull('success-message') }}","success");
		@endif

		@if( Session::has("error-message") )
			swal("Oops...","{{ Session::pull('error-message') }}","error");
		@endif

		$('#page-body').show();
	})
</script>
@stop
