@extends('layouts.master-blue')
@section('title')
Inventory
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('content')
<div class="container-fluid" id="page-body" hidden>
	@include('inventory.sidebar.item')
	<div class="col-sm-4 panel panel-body">
		<div class="col-md-8 col-sm-8 text-primary">
			<strong>Create an item profile</strong>. 
		</div>
		<div class="col-md-4">
			{{ Form::open(['method'=>'get','route'=>'inventory.item.create']) }}
			{{ Form::submit('Create',[
				'class' => 'btn btn-primary btn-block'
			]) }}
			{{ Form::close() }}
		</div>
	</div>
	<div class="col-sm-10 panel panel-body table-responsive">
		<table class="table table-hover table-striped table-condensed" id="inventoryTable">
			<thead>
				<th>Item name</th>
				<th>Added</th>
				<th>Condemned</th>
				<th>Total</th>
				<th class='text-center'>Action</th>
			</thead>
			<tbody>
			@if( empty($inventorydetails) )
				<tr>
					<td> --- </td>
					<td> --- </td>
					<td> --- </td>
					<td> --- </td>
					<td> --- </td>
					<td> --- </td>
				</tr>
			@else
				@foreach( $inventorydetails as $inventory )
				<tr>
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
						<input type="hidden" name='itemname' value="{{ $inventory->itemname }}">
						@if(count($inventory->itemprofile) > 0)
							@foreach($inventory->itemprofile as $item)
							<input type="hidden" name="itemtype" value="{{ $item->type }}" />
							@endforeach
						@endif
						{{ Form::submit('Add',[
							'class'=>'btn btn-sm btn-primary btn-block',
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
	} );
</script>
@stop
