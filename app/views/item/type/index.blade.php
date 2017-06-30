@extends('layouts.master-blue')
@section('title')
Item Types
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
<link rel="stylesheet" href="{{ asset('css/style.css') }}"  />
<style>
	#page-body{
		display:none;
	}
</style>
@stop
@section('content')
<div class="container-fluid" id="page-body">
	@include('item.type.sidebar.default')
	<div class="col-md-12" id="itemtype-info">
		<div class="col-sm-12 panel panel-body  table-responsive">
			<table class="table table-striped table-hover table-bordered" id='itemTypeTable'>
				<thead>
					<th>ID</th>
					<th>Item type</th>
					<th>Description</th>
					<th>Fields</th>
				</thead>
				<tbody>
				@forelse( $itemtype as $itemtype )
				<tr>
					<td> {{ $itemtype->id }} </td>
					<td> {{ $itemtype->name }} </td>
					<td> {{ $itemtype->description }} </td>
					<td> {{ $itemtype->field }} </td>
				</tr>
				@empty
				@endforelse
				</tbody>
			</table>
		</div>
	</div>
</div>
@stop
@section('script')
<script type="text/javascript">
	$(document).ready(function(){

		@if( Session::has("success-message") )
		  swal("Success!","{{ Session::pull('success-message') }}","success");
		@endif
		@if( Session::has("error-message") )
		  swal("Oops...","{{ Session::pull('error-message') }}","error");
		@endif

		$('#itemTypeTable').DataTable();

		$('#page-body').show();

	});
</script>
@stop
