@extends('layouts.master-blue')
@section('title')
Room Inventory
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('content')
<div class="container-fluid">
	@include('inventory.sidebar.room')
	<div class="col-md-4 col-sm-4 panel panel-body">
		<div class="col-md-8 col-sm-8 text-primary">
			<strong>Assign a workstation to a room</strong>. 
		</div>
		<div class="col-md-4">
			{{ Form::open(['method'=>'get','route'=>'inventory.room.create']) }}
			{{ Form::submit('Assign',[
				'class' => 'btn btn-primary btn-block'
			]) }}
			{{ Form::close() }}
		</div>
	</div>
	<div class="col-sm-10 panel panel-body table-responsive">
		<table class="table table-hover table-striped table-condensed" id="inventoryTable">
			<thead>
				<th>Room Name</th>
				<th>Item Name</th>
				<th>System Unit</th>
				<th>Display</th>
				<th>Mouse</th>
				<th>Keyboard</th>
				<th>Action</th>
			</thead>
			<tbody>
			@if( empty($roominventory) )
				<tr>
					<td> --- </td>
					<td> --- </td>
					<td> --- </td>
					<td> --- </td>
					<td> --- </td>
					<td> --- </td>
					<td> --- </td>
				</tr>
			@else
				@foreach( $roominventory as $inventory )
				<tr>
					@if(count($inventory->room) > 0)
					<td> {{ $inventory->room->name }} </td>
					@endif
					@if( count($inventory->pc) > 0)
					<td> {{ $inventory->pc->name }} </td>
					<td> {{ $inventory->pc->systemunit->property_number }} </td>
					<td> {{  $inventory->pc->display->property_number }} </td>
					<td> {{  $inventory->pc->mouse }} </td>
					<td> {{  $inventory->pc->keyboard }} </td>
					@endif
					@if( count($inventory->item_id) > 0 )
					<td>
						<div class="pull-left">
						{{ Form::open(['method'=>'get','route' => array('inventory.room.show',$inventory->item_id)]) }}
						{{ Form::submit('View',[
							'class'=>'btn btn-sm btn-info',
							'name'=>'view'
						]) }}
						{{ Form::close() }}
						</div>
						<div class="pull-left">
						{{ Form::open(['method'=>'get','route' => array('inventory.room.edit',$inventory->item_id)]) }}	
						<input type="hidden" name='itemname' value="{{ $inventory->itemname }}">
						{{ Form::submit('Transfer',[
							'class'=>'btn btn-sm btn-success',
							'name'=>'transfer'
						]) }}
						{{ Form::close() }}
						</div>
						<div class="pull-right">
						{{ Form::open(['method'=>'delete','route' => array('inventory.room.destroy',$inventory->item_id)]) }}	
						{{ Form::submit('Condemn',[
							'class'=>'btn btn-sm btn-warning pull-right',
							'name'=>'condemn'
						]) }}
						{{ Form::close() }}
						</div>
					</td>
					@endif
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
	@if( Session::has("success-message") )
	  swal("Success!","{{ Session::pull('success-message') }}","success");
	@endif
	@if( Session::has("error-message") )
	  swal("Oops...","{{ Session::pull('error-message') }}","error");
	@endif
	$(document).ready(function() {
	    $('#inventoryTable').DataTable();
	} );
</script>
@stop
