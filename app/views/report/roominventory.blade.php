@extends('layouts.master-blue')
@section('title')
Room Inventory Report
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
			<table class="table table-hover table-striped" id="logTable">
				<thead>
					<th> Item </th>
					<th> Property Number </th>
					<th> Borrower </th>
					<th> Faculty-in-charge </th>
					<th> Date of Use </th>
					<th> Time start </th>
					<th> Time end </th>
				</thead>
				<tbody>
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
	    $('#logTable').DataTable({
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