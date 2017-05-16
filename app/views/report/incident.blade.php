@extends('layouts.master-blue')
@section('title')
Incident Report
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
					<th> Receiver </th>
					<th> Details </th>
					<th> Date occured </th>
					<th> Action Taken </th>
				</thead>
				<tbody>
				@if(count($incident) > 0)
					@foreach($incident as $log)
					<tr>
						<td> {{ $log->itemprofile->inventory->itemname }} </td>
						<td> {{ $log->itemprofile->property_number }} </td>
						<td> {{ $log->user->firstname }} {{ $log->user->lastname }} </td>
						<td> {{ $log->description }} </td>
						<td> {{ Carbon::parse($log->created_at)->toFormattedDateString() }} </td>
						@if(count($log->actiontaken) == 0)
						<td> None	 </td>
						@else
						<td> {{ $log->actiontaken->description }} </td>
						@endif
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