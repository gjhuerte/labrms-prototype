@extends('layouts.master-blue')
@section('title')
Inventory | Supplies
@stop
@section('navbar')
@include('layouts.navbar.admin.default')
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
	 		{{ Form::open(['method'=>'post','route'=>'supplies.store','class'=>'form-horizontal','id'=>'inventoryForm']) }}
			<ul class="breadcrumb">
				<li><a href="{{ url('inventory/item') }}">Inventory</a></li>
				<li><a href="{{ url('supplies') }}">Supplies</a></li>
				<li class="active">Create</li>
			</ul>
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
					<button type="submit" value="create" name="action" id="submit" class="btn btn-lg btn-primary btn-block btn-flat btn-block"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Submit </button>
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
				url: "{{ url('get/item/type/inventory/item') }}",
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
