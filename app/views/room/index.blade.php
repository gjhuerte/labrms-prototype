@extends('layouts.master-blue')
@section('title')
Room
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
</style>
@stop
@section('content')
<div class="container-fluid" id="page-body">
	@include('room.sidebar.default')
	<div class="col-md-12" id="room-info">
		<div class="panel panel-body  table-responsive">
			<table class="table table-hover table-condensed table-bordered table-striped" id="roomTable">
				<thead>
					<th>Name</th>
					<th>Description</th>
				</thead>
				<tbody>
				@if(empty($rooms))
				@else
					@foreach($rooms as $room)
					<tr>
						<td>{{ $room->name }}</td>
						<td>{{ $room->description }}</td>
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
		$('#page-body').show();
		$('#roomTable').DataTable();

		$('.delete').click(function(){
			swal({
				title: "Are you sure?",
				text: "This process is irreversible, do you want to continue?",
				type: "warning",
				showCancelButton: true,
				confirmButtonText: "Yes, i want to continue!",
				cancelButtonText: "No, cancel it!",
				closeOnConfirm: false,
				closeOnCancel: false
			},
			function(isConfirm){
				if (isConfirm) {
					$("#deletionForm").submit();
				} else {
					swal("Cancelled", "Deletion Cancelled", "error");
				}
			});
		});

		@if( Session::has("success-message") )
			swal("Success!","{{ Session::pull('success-message') }}","success");
		@endif
		@if( Session::has("error-message") )
			swal("Oops...","{{ Session::pull('error-message') }}","error");
		@endif
	} );
</script>
@stop
