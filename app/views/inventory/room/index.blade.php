@extends('layouts.master-blue')
@section('title')
Room Inventory
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('script-include')
{{ HTML::script(asset('js/jquery.hideseek.min.js')) }}
@stop
@section('style')
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
<style>
	#page-body{
		display: none;
	}
</style>
@stop
@section('content')
<div class="container-fluid" id="page-body">
	<div class="col-md-2">
    <div class="panel panel-body panel-shadow">
        <div>
					<button class="btn btn-default btn-block" id="assign">Assign</button>
					<table class="table table-hover" >
						<thead>
							<th>Rooms</th>
						</thead>
						<tbody>
							@foreach($rooms as $room)
							<tr>
								<td class="text-muted">{{ $room->name }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
    </div>
	</div>
	<div class="col-md-10">
		<div class="panel panel-body panel-shadow table-responsive">
			<table class="table table-hover table-condensed table-bordered" id="roomTable">
				<thead>
					<th>Item Model</th>
					<th>Item Brand</th>
					<th>Property Number</th>
					<th>Date Assigned</th>
				</thead>
				<tbody></tbody>
			</table>
		</div>
	</div>
</div>
@stop
@section('script')
<script type="text/javascript">
	$(document).ready(function() {

		$('#assign').click(function(){
				window.location.href = "{{ url('inventory/room/assign') }}";
		});

		@if( Session::has("success-message") )
			swal("Success!","{{ Session::pull('success-message') }}","success");
		@endif
		@if( Session::has("error-message") )
			swal("Oops...","{{ Session::pull('error-message') }}","error");
		@endif

		$('#roomTable').DataTable({
    	columnDefs:[
			{ targets: 'no-sort', orderable: false },
    	],
    });

		$('#page-body').show();
	} );
</script>
@stop
