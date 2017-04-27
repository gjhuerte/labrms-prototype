@extends('layouts.master-blue')
@section('title')
Receive
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('content')
<div class="container-fluid">
	@include('inventory.sidebar.default')
	<div class="col-md-10">
		<div class="panel panel-body table-responsive">
			<table class="table table-hover table-striped" id="approvalTable">
				<thead>
					<th> Item </th>
					<th> Borrower </th>
					<th> Faculty-in-charge </th>
					<th> Location </th>
					<th> Date Borrowed </th>
					<th> Time start </th>
					<th> Action </th>
				</thead>
				<tbody>
				@if(count($lend) == 0)
				@else
					@foreach($lend as $lend)
					<tr>
						<td> {{ $lend->itemprofile->property_number }}</td>
						<td> {{ $lend->clientname }}  </td>
						<td> {{ $facultyincharge }} </td>
						<td> {{ $reservation->facultyincharge }} </td>
						<td> {{ Carbon\Carbon::parse($lend->date)->toFormattedDateString() }} </td>
						<td> {{ Carbon\Carbon::parse($lend->timein)->toTimeString() }} </td>
						<td> {{ Carbon\Carbon::parse($lend->timeout)->toTimeString() }} </td>
						<td>
							{{ Form::open(['method'=>'put','route'=>array('lend.update',$lend->id)]) }}
							{{ Form::submit('Received',[
								'class'=>'btn btn-danger btn-xs btn-block',
								'name'=>'Receive'
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