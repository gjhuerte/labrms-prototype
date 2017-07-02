@extends('layouts.master-blue')
@section('title')
Workstation
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
<link rel="stylesheet" href="{{ url('css/style.css') }}"  />
<style>
	#page-body{
		display: none;
	}
</style>
@stop
@section('content')
<div class="container-fluid" id="page-body">
	<div class="col-md-12" id="workstation-info">
		<div class="panel panel-body  table-responsive">
				<table class="table table-hover table-striped table-bordered" id="workstationTable">
					<thead>
						<th>OS</th>
						<th>System Unit</th>
						<th>Monitor</th>
						<th>AVR</th>
						<th>Keyboard</th>
						<th>Mouse</th>
					</thead>
				</table>
		</div>
	</div>
</div>
@stop
@section('script')
<script type="text/javascript">

	$(document).ready(function() {

		@if( Session::has("success-message") )
		  swal("Success!","{{ Session::pull('success-message') }}","success");
		@endif
		@if( Session::has("error-message") )
		  swal("Oops...","{{ Session::pull('error-message') }}","error");
		@endif

    	var table = $('#workstationTable').DataTable( {
	  		select: {
	  			style: 'single'
	  		},
		    language: {
		        searchPlaceholder: "Search..."
		    },
	    	"dom": "<'row'<'col-sm-9'<'toolbar'>><'col-sm-3'f>>" +
						    "<'row'<'col-sm-12'tr>>" +
						    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
			"processing": true,
	        ajax: "{{ url('workstation') }}",
	        columns: [
	            { data: "os" },
	            { data: "systemunit" },
	            { data: "monitor" },
	            { data: "avr" },
	            { data: "keyboard" },
	            { data: "mouse" },
	        ],
	    } );

	 	$("div.toolbar").html(`

	 			<a id="new" class="btn btn-primary btn-flat" style="margin-right:5px;padding: 5px 10px;" href="{{ url('workstation/create') }}"><span class="glyphicon glyphicon-plus"></span>  Create</a>
	 			<button id="new" class="btn btn-info btn-flat" style="margin-right:5px;padding: 5px 10px;" data-target="#createFacultyModal" data-toggle="modal"><span class="glyphicon glyphicon-share-alt"></span>  Deploy</button>
	 			<a id="edit" class="btn btn-warning btn-flat" style="margin-right:5px;padding: 6px 10px;" href="{{ url('workstation/view/transfer') }}"><span class="glyphicon glyphicon-share"></span>  Transfer</a>
	 			<button id="delete" class="btn btn-danger btn-flat" style="margin-right:5px;padding: 5px 10px;"><span class="glyphicon glyphicon-trash"></span> Disassemble</button>
		`);

		$('#page-body').show();
  	});
</script>
@stop
