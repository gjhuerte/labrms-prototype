@extends('layouts.master-blue')
@section('title')
Inventory
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('content')
<div class="container-fluid" id="page-body" hidden>
	@include('inventory.sidebar.default')
	<div class="col-md-10">
		<div class="panel panel-body table-responsive">
			<table class="table table-hover table-striped table-condensed" id="inventoryTable">
				<thead>
					<th>Item name</th>
					<th>Added</th>
					<th>Condemned</th>
					<th>Total</th>
					<th class='text-center'></th>
				</thead>
				<tbody>
				@if( empty($inventorydetails) )
				@else
					@foreach( $inventorydetails as $inventory )
					<tr data-id="{{ $inventory->itemname }}">
						<td> {{ $inventory->itemname }} </td>
						<td> {{ $inventory->added }} </td>
						<td> {{ $inventory->deduct }} </td>
						<td> {{ $inventory->total }} </td>
						<td>
							<div class="col-md-6">
							{{ Form::open(['method'=>'get','route' => array('inventory.item.show',$inventory->id)]) }}
							{{ Form::submit('View',[
								'class'=>'btn btn-sm btn-info btn-block',
								'name'=>'view'
							]) }}
							{{ Form::close() }}
							</div>
							<div class="col-md-6">
							{{ Form::open(['method'=>'get','route' => array('inventory.item.create')]) }}
							{{ Form::button('Add',[
								'class'=>'btn btn-sm btn-primary btn-block add',
								'name'=>'add'
							]) }}
							{{ Form::close() }}
							</div>
						</td>
					</tr>
					@endforeach
				@endif
				</tbody>
			</table>
		</div>
	</div>
</div>
@stop
@section('script')
<script type="text/javascript">
	$(document).ready(function() {
		$('#page-body').show(200);
	    $('#inventoryTable').DataTable();
		@if( Session::has("success-message") )
		  swal("Success!","{{ Session::pull('success-message') }}","success");
		@endif
		@if( Session::has("error-message") )
		  swal("Oops...","{{ Session::pull('error-message') }}","error");
		@endif

		$('.add').click(function(){
		  	var item = $(event.target).closest('tr').data('id');
			swal({
					title: item,
					text: "Quantity:",
					type: "input",
					inputType: "number",
					showCancelButton: true,
					closeOnConfirm: false,
					animation: "slide-from-top",
					inputPlaceholder: "Quantity",
					showLoaderOnConfirm: true,
				},
				function(inputValue){
					if (inputValue === false) return false;

					if (inputValue === "") {
						swal.showInputError("You need to write something!");
						return false;
					}

					if(isNaN(inputValue) || inputValue == false){
				  		swal.showInputError("Quantity field must have a number");
						return false;
				  	}

				  	if(inputValue < 0 || inputValue == 0){
				  		swal.showInputError("Number must be greater than zero");
				  		return false;
				  	}

					setTimeout(function(){
						swal("Ajax request finished!");
					}, 2000);
			});
		});
	} );
</script>
@stop
