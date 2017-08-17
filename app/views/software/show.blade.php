@extends('layouts.master-blue')
@section('title')
Software License Information
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('content')
<div class="container-fluid">
@include('modal.software.license.add')
	<div class="col-sm-offset-2 col-sm-8">
		<div class="panel panel-default">
			<div class="panel-body" style="margin-bottom: 10px;">
				<legend><h3 class="text-muted">Software License Information</h3></legend>
				<ol class="breadcrumb">
					<li><a href="{{ url('software') }}">Software</a></li>
					<li class="active">{{ $software->softwarename }}</li>
					<li>License Keys</li>
				</ol>
				<table class="table table-hover table-striped table-bordered" id='softwareTable'>
					<thead>
						<th>ID</th>
						<th>License Key</th>
						<th>Multiple Usage</th>
						<th>Used</th>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>
@stop
@section('script')
<script type="text/javascript">
	    var table = $('#softwareTable').DataTable( {
			"pageLength": 100,
	  		select: {
	  			style: 'single'
	  		},
	    	columnDefs:[
				{ targets: 'no-sort', orderable: false },
	    	],
		    language: {
		        searchPlaceholder: "Search..."
		    },
	    	"dom": "<'row'<'col-sm-8'<'toolbar'>><'col-sm-4'f>>" +
						    "<'row'<'col-sm-12'tr>>" +
						    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
			"processing": true,
	        ajax: "{{ url('software/license') }}" + '/' + {{ $software->id }},
	        columns: [
	            { data: "id" },
	            { data: "key" },
	            { data: "multipleuse" },
	            { data: "inuse" }
	        ],
	    } );

	    $('div.toolbar').html(`
	    	<button class="btn btn-md btn-success" id="add" data-toggle="modal" data-target="#addSoftwareLicenseModal">ADD</button>
    	`)
	@if( Session::has("success-message") )
	  swal("Success!","{{ Session::pull('success-message') }}","success");
	@endif
	@if( Session::has("error-message") )
	  swal("Oops...","{{ Session::pull('error-message') }}","error");
	@endif
</script>
@stop
