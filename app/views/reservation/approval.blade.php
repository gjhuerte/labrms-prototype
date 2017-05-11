@extends('layouts.master-blue')
@section('title')
Approval
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('content')
<div class="container-fluid">
	<div class="row" style="background: white;">
		<div class="panel panel-body table-responsive">
			<table class="table table-hover table-striped" id="approvalTable">
				<thead>
					<th> Item </th>
					<th> Property Number </th>
					<th> Purpose </th>
					<th> Professor-in-charge </th>
					<th> Location </th>
					<th> Date of Use </th>
					<th> Time start </th>
					<th> Time end </th>
					<th> Action </th>
				</thead>
				<tbody>
				@if(count($reservationdetails) == 0)
					<tr>
						<td> --- </td>
						<td> --- </td>
						<td> --- </td>
						<td> --- </td>
						<td> --- </td>
						<td> --- </td>
						<td> --- </td>
						<td> --- </td>
					</tr>
				@else
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
						<td>
						@if($reservation->approval == 0)
							{{ Form::open(['method'=>'put','route'=>array('reservation.update',$reservation->id)]) }}
							{{ Form::submit('Approve',[
								'class'=>'btn btn-primary btn-sm',
								'name'=>'approve'
							]) }}
							{{ Form::submit('Disapprove',[
								'class'=>'btn btn-info btn-sm',
								'name'=>'disapprove'
							]) }}
							{{ Form::close() }}
						@else($reservation->approval == 1)
							{{ Form::open(['method'=>'delete','route'=>array('reservation.destroy',$reservation->id)]) }}
							{{ Form::submit('Cancel',[
								'class'=>'btn btn-danger btn-xs btn-block',
								'name'=>'cancel'
							]) }}
							{{ Form::close() }}
						@endif
						</td>
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
	@if( Session::has("success-message") )
	  swal("Success!","{{ Session::pull('success-message') }}","success");
	@endif
	@if( Session::has("error-message") )
	  swal("Oops...","{{ Session::pull('error-message') }}","error");
	@endif
	$(document).ready(function() {
	    $('#approvalTable').DataTable();
	} );
</script>
@stop