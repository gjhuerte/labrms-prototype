@extends('layouts.master-blue')
@section('title')
Software list
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style-include')
<style>
	#page-body{
		display: none;
	}
</style>
@stop
@section('content')
<div class="container-fluid" id="page-body">
	@include('software.sidebar.default')
	<div class="col-md-10">
		<div class="panel panel-body table-responsive">
			<table class="table table-hover table-striped" id='softwareTable'>
				<thead>
					<th>Software name</th>
					<th>Description</th>
					<th>License type</th>
					<th>Requirements</th>
					<th>Software type</th>
					<th>Action</th>
				</thead>
				<tbody>
				@if( count($softwares) == 0)
				@else
					@foreach( $softwares as $software )
					<tr>
						<td> {{{ $software->name }}} </td>
						<td> {{{ $software->description }}} </td>
						<td> {{{ $software->licensetype }}} </td>
						<td> {{{ $software->requirement }}} </td>
						<td> {{{ $software->softwaretype }}} </td>
						<td>
							{{ Form::open(['method'=>'get','route' => array('software.edit',$software->id)]) }}
							{{ Form::submit('Update',[
								'class'=>'btn btn-sm btn-primary',
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
		$('#softwareTable').dataTable();
		@if( Session::has("success-message") )
		swal("Success!","{{ Session::pull('success-message') }}","success");
		@endif
		@if( Session::has("error-message") )
		swal("Oops...","{{ Session::pull('error-message') }}","error");
		@endif
	});
</script>
@stop
