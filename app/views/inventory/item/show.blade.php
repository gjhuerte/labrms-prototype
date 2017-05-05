@extends('layouts.master-blue')
@section('title')
Item Profile
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('content')
<div class="container-fluid">
	<div class="col-sm-4 panel panel-body">
		<div class="col-md-8 text-primary">
			<strong>Create an item profile</strong>. 
		</div>
		<div class="col-md-4">
			{{ Form::open(['method'=>'get','route'=>'item.profile.create']) }}
			{{ Form::submit('Create',[
				'class' => 'btn btn-primary btn-block'
			]) }}
			{{ Form::close() }}
		</div>
	</div>
	<div class="col-sm-12 panel panel-body table-responsive">
		<table class="table table-hover table-striped table-condensed" id="itemProfileTable">
			<thead>
				<th>Property Number</th>
				<th>Serial ID</th>
				<th>MR Number</th>
				<th>Type</th>
				<th>Status</th>
				<th>Location</th>
				<th>Action</th>
			</thead>
			<tbody>
			@if( empty($items) )
				<tr>
					<td> --- </td>
					<td> --- </td>
					<td> --- </td>
					<td> --- </td>
					<td> --- </td>
					<td> --- </td>
				</tr>
			@else
				@foreach( $items as $item )
				<tr>
					<td> {{ $item->property_number }} </td>
					<td> {{ $item->serialid }} </td>
					<td> {{ $item->MR_no }} </td>
					<td> {{ $item->type }} </td>
					<td> {{ $item->status }} </td>
					<td> {{ $item->location }} </td>
					<td>
						<div class="pull-left">
						{{ Form::open(['method'=>'get','route' => array('item.profile.show',$item->id)]) }}	
						{{ Form::submit('View',[
							'class'=>'btn btn-info',
							'name'=>'view'
						]) }}
						{{ Form::close() }}
						</div>
						<div class="pull-left">
						{{ Form::open(['method'=>'get','route' => array('item.profile.edit',$item->id)]) }}
						{{ Form::submit('Update',[
							'class'=>'btn btn-primary',
							'name' => 'update'
						]) }}
						{{ Form::close() }}
						</div>
						<div class="pull-left">
						{{ Form::open(['method'=>'get','route' => array('item.profile.edit',$item->id)]) }}
						{{ Form::submit('Transfer',[
							'class'=>'btn btn-success',
							'name' => 'transfer'
						]) }}
						{{ Form::close() }}
						</div>
						<div class="pull-right">
						{{ Form::open(['method'=>'delete','route' => array('item.profile.destroy',$item->id)]) }}	
						{{ Form::submit('Condemn',[
							'class' => 'btn btn-warning',
							'name' => 'delete'
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
	$('#itemProfileTable').dataTable();
	@if( Session::has("success-message") )
	  swal("Success!","{{ Session::pull('success-message') }}","success");
	@endif
	@if( Session::has("error-message") )
	  swal("Oops...","{{ Session::pull('error-message') }}","error");
	@endif
</script>
@stop
