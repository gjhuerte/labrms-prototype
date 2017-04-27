@extends('layouts.master-blue')
@section('title')
Equipments
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
<style>
	#page-body{
		display: none;
	}
</style>
@stop
@section('content')
<div class="container-fluid" id="page-body">
	@include('equipment.sidebar.default')
	<div class="col-md-10">
		<div class="panel panel-body table-responsive">
			<table class="table table-hover table-striped" id="itemProfileTable">
				<thead>
					<th>PN</th>
					<th>Serial ID</th>
					<th>MR</th>
					<th>Item Name</th>
					<th>Type</th>
					<th>Status</th>
					<th>Location</th>
					<th>  </th>
				</thead>
				<tbody>
				@if( empty($items) )
				@else
					@foreach( $items as $item )
					<tr>
						<td> {{ $item->property_number }} </td>
						<td> {{ $item->serialid }} </td>
						<td> {{ $item->MR_no }} </td>
						<td> {{ $item->inventory->itemname }} </td>
						<td> {{ $item->type }} </td>
						<td> {{ $item->status }} </td>
						<td> {{ $item->location }} </td>
						<td>
							{{ Form::open(['method'=>'get','route' => array('equipment.edit',$item->id)]) }}
							{{ Form::submit('Update',[
								'class'=>'btn-block btn btn-sm btn-primary',
								'name' => 'update'
							]) }}
							{{ Form::close() }}
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
	$(document).ready(function(){
		$('#page-body').show();
		$('#itemProfileTable').dataTable();
		@if( Session::has("success-message") )
		  swal("Success!","{{ Session::pull('success-message') }}","success");
		@endif
		@if( Session::has("error-message") )
		  swal("Oops...","{{ Session::pull('error-message') }}","error");
		@endif
	})
</script>
@stop
