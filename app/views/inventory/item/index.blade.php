@extends('layouts.master-blue')
@section('title')
Inventory
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
<style>
	#page-body{
		display: none;
	}

	a > hover{
		text-decoration: none;
	}

	th , tbody{
		text-align: center;
	}
</style>
@stop
@section('content')
<div class="container-fluid" id="page-body">
	@include('inventory.sidebar.default')
	@include('modal.inventory.add')
	<div class="col-md-12" style="margin: 5px 0px;">
		<button class="btn btn-default" id="simple-menu" href="#sidr" style="border:none;padding: 10px;"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> <span id="nav-text">Toggle Navigation</span></button>
	</div>
	<div class="col-md-12">
		<div class="panel panel-body table-responsive">
			<table class="table table-hover table-striped table-bordered table-condensed" id="inventoryTable">
				<thead>
					<th>Model</th>
					<th>Brand</th>
					<th>Type</th>
					<th>Description</th>
					<th>Warranty</th>
					<th>Unit</th>
					<th>Quantity</th>
					<th>Unprofiled</th>
					<th class="no-sort"></th>
				</thead>
				<tbody>
				@if( !empty($inventory) )
					@foreach( $inventory as $inventory )
					<tr>
						<td>
							<span class="truncate">{{{ $inventory->model }}}</span>
							@if(isset($inventory->model) && strlen($inventory->model) > 20 )
							<a tabindex="0" class="btn btn-link" role="button" data-toggle="popover" data-trigger="focus" data-content="{{{ $inventory->model }}}">more</a>
							@endif
						</td>
						<td>
							<span class="truncate">{{{ $inventory->brand }}}</span>
							@if(isset($inventory->brand) && strlen($inventory->brand) > 20 )
							<a tabindex="0" class="btn btn-link" role="button" data-toggle="popover" data-trigger="focus" data-content="{{{ $inventory->brand }}}">more</a>
							@endif
						</td>
						<td>
							<span class="truncate">{{{ $inventory->itemtype->name }}}</span>
							@if(isset($inventory->itemtype->name) && strlen($inventory->itemtype->name) > 20 )
							<a tabindex="0" class="btn btn-link" role="button" data-toggle="popover" data-trigger="focus" data-content="{{{ $inventory->itemtype->name }}}">more</a>
							@endif
						</td>
						<td>
							<span class="truncate">{{{ $inventory->details }}}</span>
							@if( isset($inventory->details) && strlen($inventory->details) > 20 )
							<a tabindex="0" class="btn btn-link" role="button" data-toggle="popover" data-trigger="focus" data-content="{{{ $inventory->details }}}">more</a>
							@endif
						</td>
						<td>
							<span class="truncate">{{{ $inventory->warranty }}}</span>
							@if(isset($inventory->warranty) && strlen($inventory->warranty) > 20 )
							<a tabindex="0" class="btn btn-link" role="button" data-toggle="popover" data-trigger="focus" data-content="{{{ $inventory->warranty }}}">more</a>
							@endif
						</td>
						<td>{{{ $inventory->unit }}}</td>
						<td>
							  {{{ $inventory->quantity }}}
						</td>
						<td>{{{ ($inventory->profileditems == null) ? $inventory->quantity : $inventory->quantity - $inventory->profileditems }}}
						</td>
						<td class="col-md-2 col-xs-2">
							<div class="btn-group btn-group-justified" role="group">
								<div class="btn-group" role="group">
								{{ Form::open(['method'=>'get','route'=>array('item.profile.create')]) }}
									<input type="hidden" name="id" value="{{ $inventory->id }}">
									<button class="btn btn-default btn-flat" type="submit">
									  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> <span class="hidden-sm hidden-xs">Profile</span>
									</button>
									{{ Form::close() }}
								</div>
								<div class="btn-group" role="group">
								{{Form::open(['method'=>'get','route'=>array('item.profile.show',$inventory->id)]) }}
									<button class="btn btn-primary btn-flat" type="submit">
									  <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> <span class="hidden-sm hidden-xs">View</span>
									</button>
								{{ Form::close() }}
								</div>
								<div class="btn-group" role="group">
									<button class="btn btn-success btn-flat add" data-id="{{ $inventory->id }}" data-model="{{ $inventory->model }}" type="button" data-toggle="modal" data-target="#inventoryAdd">
									  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> <span class="hidden-sm hidden-xs">Add</span>
									</button>
								</div>
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

	    $('#inventoryTable').DataTable({
	    	columnDefs:[
				{ targets: 'no-sort', orderable: false },
	    	],
	    });

	    $('[data-toggle="popover"]').popover();

		@if( Session::has("success-message") )
		  swal("Success!","{{ Session::pull('success-message') }}","success");
		@endif
		@if( Session::has("error-message") )
		  swal("Oops...","{{ Session::pull('error-message') }}","error");
		@endif

    $('.truncate').succinct({
        size: 20
    });

		$('#page-body').show();
	} );
</script>
@stop
