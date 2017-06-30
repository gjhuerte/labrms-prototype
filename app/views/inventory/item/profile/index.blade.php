@extends('layouts.master-blue')
@section('title')
Inventory
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
{{ HTML::style(asset('css/style.min.css')) }}
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
@section('script-include')
<script src="{{ asset('js/jQuery.succinct.min.js') }}"></script>
@stop
@section('content')
<div class="container-fluid" id="page-body">
	<div class="col-md-12">
		<div class="panel panel-body table-responsive">
			<ol class="breadcrumb">
			  <li><a href="{{ url('inventory/item') }}">Inventory</a></li>
			  <li><a href="{{ url('inventory/item') }}">Item</a></li>
			  <li class="active">{{{ $id }}}</li>
			</ol>
			<table class="table table-hover table-striped table-bordered table-condensed" id="itemProfileTable">
				<thead>
					<th>Property Number</th>
					<th>Serial Number</th>
					<th>Location</th>
					<th>Date Received</th>
					<th>Status</th>
					<th class="no-sort"></th>
				</thead>
				<tbody>
				@if( !empty($itemprofile) )
					@foreach( $itemprofile as $itemprofile )
					<tr>
						<td>
							{{{ $itemprofile->propertynumber }}}
						</td>
						<td>
							{{{ $itemprofile->serialnumber }}}
						</td>
						<td>
							{{{ $itemprofile->location }}}
						</td>
						<td>
							{{ Carbon\Carbon::parse($itemprofile->datereceived)->toFormattedDateString() }}
						</td>
						<td>
							{{{ $itemprofile->status }}}
						</td>
						<td class="col-md-2">
							<div class="btn-group btn-group-justified">
								<div class="btn-group">
										{{ Form::open(['method'=>'get','route'=>array('item.profile.edit',$itemprofile->id)]) }}
											<button class="btn btn-default btn-flat" type="submit">
											  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> <span class="hidden-sm hidden-xs">Update</span>
											</button>
											{{ Form::close() }}
								</div>
								<div class="btn-group">
										{{ Form::open(['method'=>'get','route'=>array('item.profile.destroy',$itemprofile->id)]) }}
											<button class="btn btn-danger btn-flat" type="submit">
											  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> <span class="hidden-sm hidden-xs">Condemn</span>
											</button>
										{{ Form::close() }}
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

	    $('#itemProfileTable').DataTable({
	    	columnDefs:[
				{ targets: 'no-sort', orderable: false },
	    	],
	    });

		@if( Session::has("success-message") )
		  swal("Success!","{{ Session::pull('success-message') }}","success");
		@endif
		@if( Session::has("error-message") )
		  swal("Oops...","{{ Session::pull('error-message') }}","error");
		@endif

		$('#page-body').show();
	} );
</script>
@stop
