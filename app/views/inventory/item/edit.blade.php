@extends('layouts.master-blue')
@section('title')
Inventory | Update
@stop
@section('navbar')
@include('layouts.navbar.admin.default')
@stop
@section('style')
{{ HTML::style(asset('css/style.css')) }}
{{ HTML::style(asset('css/jquery-ui.min.css')) }}
<style>
	#page-body{
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
	 		{{ Form::open(['method'=>'put','route'=>array('inventory.item.update',$inventory->id),'class'=>'form-horizontal','id'=>'inventoryForm']) }}
	 		<div id="inventory">
				<legend><h3 style="color:#337ab7;">Inventory</h3></legend>
				<ul class="breadcrumb">
					<li><a href="{{ url('inventory/item') }}">Item Inventory</a></li>
					<li class="active">Update</li>
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
						'id' => 'details',
						'rows' => 3
					]) }}
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
					{{ Form::label('unit','Unit') }}
					{{ Form::text('unit',Input::old('unit'),[
						'class' => 'form-control',
						'placeholder' => 'Unit',
						'id' => 'unit'
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
					<div class="col-sm-12">
						<button type="submit" value="create" name="action" id="submit" class="btn btn-primary btn-lg btn-flat btn-block"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Update </button>
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
			$('#brand').val("{{ $inventory->brand }}")
			$('#model').val("{{ $inventory->model }}")
			$('#details').val("{{ $inventory->details }}")
			$('#unit').val("{{ $inventory->unit }}")
			$('#warranty').val("{{ $inventory->warranty }}")
			$.ajax({
				type: "get",
				url: "{{ url('item/type') }}",
				dataType: 'json',
				success: function(response){
					var options = "";

					for(var ctr = 0;ctr < response.data.length;ctr++)
					{
						options += `<option value="`+response.data[ctr].id+`">
							`+response.data[ctr].name+`
						</option>`;
					}

					$('#itemtype').html("");
					$('#itemtype').append(options);
				},
				complete: function(){

					@if(Input::old('itemtype'))
					$('#itemtype').val("{{ Input::old('itemtype') }}")
					@else
					inventory = '{{ $inventory->itemtype_id }}'
					$('#itemtype').val(inventory)
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
