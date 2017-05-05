@extends('layouts.master-blue')
@section('title')
Approval
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('content')
<div class="container-fluid" id="page-body" hidden>
	<div class="col-sm-2">
		<div class="panel panel-body">
			<div class="list-group">
			  <a href="#" class="list-group-item active" id="overview">
			    Overview
			  </a>
			  <a href="#" class="list-group-item" id="activation">Approve</a>
			  <a href="#" class="list-group-item" id="adminpriviledge">Disapprove</a>
			  <a href="#" class="list-group-item" id="blocked">Cancellation</a>
			  <a href="#" class="list-group-item" id="removed">Special Events</a>
			</div>
		</div>
	</div>
	<div class="col-sm-10">
		<div class="panel panel-body table-responsive">
			<table class="table table-hover table-striped table-condensed" id="approvalTable">
				<thead>
					<th> Item </th>
					<th> Property Number </th>
					<th> Purpose </th>
					<th> Professor-in-charge </th>
					<th> Location </th>
					<th> Date of Use </th>
					<th> Time start </th>
					<th> Time end </th>
				</thead>
				<tbody>
				@if(count($reservationdetails) > 0)
					@foreach($reservationdetails as $reservation)
						@if( count($reservation->itemprofile) > 0)
						<tr>
							<td> {{ $reservation->itemprofile->property_number }}  </td>
							<td> {{ $reservation->itemprofile->inventory->itemname }}</td>
							<td> {{ $reservation->purpose }} </td>
							<td> {{ $reservation->facultyincharge }} </td>
							<td> {{ $reservation->location }} </td>
							<td> {{ Carbon\Carbon::parse($reservation->dateofuse)->toFormattedDateString() }} </td>
							<td> {{ Carbon\Carbon::parse($reservation->timein)->toTimeString() }} </td>
							<td> {{ Carbon\Carbon::parse($reservation->timeout)->toTimeString() }} </td>
						</tr>
						@endif
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
		$('#page-body').show(400);
	    $('#approvalTable').DataTable();
		@if( Session::has("success-message") )
		  swal("Success!","{{ Session::pull('success-message') }}","success");
		@endif
		@if( Session::has("error-message") )
		  swal("Oops...","{{ Session::pull('error-message') }}","error");
		@endif
	} );
</script>
@stop