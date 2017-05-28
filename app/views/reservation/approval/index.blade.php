@extends('layouts.master-blue')
@section('title')
Approval
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
{{ HTML::style(asset('css/style.css')) }}
<style>
	#page-body{
		display: none;
	}
</style>
@stop
@section('content')
<div class="container-fluid" id="page-body">
	<div class="panel panel-body panel-shadow table-responsive">
		<table class="table table-hover table-striped table-condensed table-bordered" id="approvalTable">
			<thead>
				<th>Borrower</th>
				<th>Items borrowed</th>
				<th>Property Number</th>
				<th>In-charge</th>
				<th>Date of Use</th>
				<th>Status</th>
				<th class="no-sort"></th>
			</thead>
			<tbody>
			@forelse($reservation as $reservation)
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			@empty
			@endforelse
			</tbody>
		</table>
	</div>
</div>
@stop
@section('script')
<script type="text/javascript">
	$(document).ready(function() {

    $('#approvalTable').DataTable({
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
