@extends('layouts.master-blue')
@section('title')
Item Profile Report
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style-include')
    {{ HTML::style(asset('css/buttons.bootstrap.min.css')) }}
@stop
@section('script-include')
    {{ HTML::script(asset('js/dataTables.buttons.min.js')) }}
    {{ HTML::script(asset('js/buttons.bootstrap.min.js')) }}
    {{ HTML::script(asset('js/buttons.colVis.min.js')) }}
    {{ HTML::script(asset('js/buttons.html5.min.js')) }}
    {{ HTML::script(asset('js/buttons.print.min.js')) }}
    {{ HTML::script(asset('js/jszip.min.js')) }}
    {{ HTML::script(asset('js/pdfmake.min.js')) }}
    {{ HTML::script(asset('js/vfs_fonts.js')) }}
@stop
@section('content')
<div class="container-fluid">
	<div class="row" style="background: white;">
		<div class="panel panel-body table-responsive">
			<table class="table table-hover table-striped" id="incidentTable">
				<thead>
					<th> Item </th>
					<th> Property Number </th>
					<th> Item type </th>
					<th> Details </th>
					<th> Receiver </th>
					<th> Date Received </th>
					<th> Status </th>
				</thead>
				<tbody>
				@if(count($itemprofile) > 0)
					@foreach($itemprofile as $log)
					<tr>
						<td> {{ $log->inventory->itemname }} </td>
						<td> {{ $log->property_number }} </td>
						<td> {{ $log->type }} </td>
						<td> {{ $log->description }} </td>
						@foreach($log->ticket as $ticket)
						<td> {{ $ticket->user->firstname }} {{ $ticket->user->lastname }} </td>
						<td> {{ Carbon\Carbon::parse($ticket->created_at)->toFormattedDateString() }} </td>
						@endforeach
						<td> {{ $log->status }} </td>
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
	    $('#incidentTable').DataTable({
	        dom: 'Bfrtip',
	        buttons: [
	            {
	                extend: 'copyHtml5',
	                exportOptions: {
	                 columns: ':contains("Office")'
	                }
	            },
	            'excelHtml5',
	            'csvHtml5',
	            'pdfHtml5'
	        ]
	    } );
	} );
</script>
@stop