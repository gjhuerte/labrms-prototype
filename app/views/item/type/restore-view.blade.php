@extends('layouts.master-blue')
@section('title')
Item Types
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
<style>
	#page-body{
		display:none;
	}
</style>
@stop
@section('content')
<div class="container-fluid" id="page-body">
	<div class="col-md-12" id="itemtype-info">
		<div class="col-sm-12 panel panel-body  table-responsive">
			<ul class="breadcrumb">
				<li>{{ HTML::link('item/type','Item Type') }}</li>
				<li class="active">Restore</li>
			</ul>
			<table class="table table-striped table-hover table-bordered" id='itemTypeTable'>
				<thead>
					<th>ID</th>
					<th>Item type</th>
					<th>Description</th>
					<th>Fields</th>
					<th class="no-sort"></th>
				</thead>
				<tbody>
				@forelse( $itemtype as $itemtype )
				<tr>
					<td> {{ $itemtype->id }} </td>
					<td> {{ $itemtype->name }} </td>
					<td> {{ $itemtype->description }} </td>
					<td> {{ $itemtype->field }} </td>
					<td>
						{{ Form::open(['method'=>'post','route' => array('item.type.restore',$itemtype->id),'id'=>'restoreForm']) }}
						<button class="btn btn-md btn-default btn-block delete" name="delete" type="submit" value="Condemn"><span class="glyphicon glyphicon-check" aria-hidden="true"></span> <span class="hidden-xs">Restore</span></button>
						{{ Form::close() }}
					</td>
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

		$('#itemTypeTable').DataTable({
			columnDefs:[
			{ targets: 'no-sort', orderable: false },
			],
		});

		$('#page-body').show();

	});
</script>
@stop
