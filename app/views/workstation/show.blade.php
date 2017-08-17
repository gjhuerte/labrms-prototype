@extends('layouts.master-blue')
@section('title')
Workstation Profile
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
{{ HTML::style(asset('css/jquery-ui.css')) }}
{{ HTML::style(asset('css/style.css')) }}
<style>

	.modal {
	  text-align: center;
	}

	@media screen and (min-width: 768px) { 
	  .modal:before {
	    display: inline-block;
	    vertical-align: middle;
	    content: " ";
	    height: 100%;
	  }
	}

	.modal-dialog {
	  display: inline-block;
	  text-align: left;
	  vertical-align: middle;
	}

	#page-body{
		display: none;
	}
</style>
@stop
@section('content')
<div class="container-fluid" id="page-body">
	@include('modal.workstation.software.install')
	@include('modal.workstation.software.edit')
	<div class="col-sm-12">
		<div class="panel panel-default" style="padding:0px 20px">
			<div class="panel-body">
				<legend><h3 class="text-muted">Workstation</h3></legend>
				<ul class="breadcrumb">
					<li><a href="{{ url('workstation') }}">Workstation</a></li>
					<li class="active">{{ $workstation->id }}</li>
				</ul>
				<table class="table table-bordered">
					<thead>
						<th>OS License Key</th>
						<th>System Unit</th>
						<th>Monitor</th>
						<th>Keyboard</th>
						<th>Mouse</th>
						<th>Location</th>
					</thead>
					<tbody>
						<tr>
							<td>{{ $workstation->oskey }}</td>
							<td>{{ ($workstation->systemunit) ? $workstation->systemunit->propertynumber : "" }}</td>
							<td>{{ ($workstation->monitor) ? $workstation->monitor->propertynumber : "" }}</td>
							<td>{{ ($workstation->keyboard) ? $workstation->keyboard->propertynumber : "" }}</td>
							<td>{{ $workstation->mouse }}</td>
							<td>{{ $workstation->systemunit->location }}</td>
						</tr>
					</tbody>
				</table>
				<div>
				  <!-- Nav tabs -->
				  <ul class="nav nav-tabs" role="tablist">
				    <li role="presentation"><a href="#history" aria-controls="history" role="tab" data-toggle="tab">History</a></li>
				    <li role="presentation" class="active"><a href="#software" aria-controls="software" role="tab" data-toggle="tab">Software</a></li>
				  </ul>

				  <!-- Tab panes -->
				  <div class="tab-content">
				    <div role="tabpanel" class="tab-pane" id="history">
				    	<div class="panel panel-body" style="padding: 10px;">
							<table class="table table-bordered" id="historyTable">
								<thead>
						            <th>ID</th>
						            <th>Name</th>
						            <th>Details</th>
						            <th>Author</th>
						            <th>Staff Assigned</th>
						            <th>Status</th>
						        </thead>
							</table>
						</div>
				    </div>
				    <div role="tabpanel" class="tab-pane active" id="software">
				    	<div class="panel panel-body" style="padding: 10px;">
							<table class="table table-bordered" id="softwareTable">
								<thead>
									<th>Software</th>
									<th>Status</th>
								</thead>
							</table>
						</div>
				    </div>
				  </div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop
@section('script')
{{ HTML::script(asset('js/jquery-ui.js')) }}
<script type="text/javascript">
$(document).ready(function(){

	var historyTable = $('#historyTable').DataTable( {
	    language: {
	        searchPlaceholder: "Search..."
	    },
	    order: [[ 0, "desc" ]],
		"processing": true,
        ajax: "{{ url("ticket/workstation/$workstation->id") }}",
        columns: [
        	{ data: 'id' },
        	{ data: 'ticketname' },
        	{ data: 'details' },
        	{ data: 'author' },
        	{ data: 'staffassigned' },
        	{ data: 'status' }
        ],
    } );

	var table = $('#softwareTable').DataTable( {
		"pageLength": 100,
  		select: {
  			style: 'multiple'
  		},
    	columnDefs:[
			{ targets: 'no-sort', orderable: false },
    	],
	    language: {
	        searchPlaceholder: "Search..."
	    },
		"processing": true,
        ajax: "{{ url("workstation/$workstation->id") }}",
        columns: [
        	{ data: function(callback){
        		return callback.softwarename
        	}},
        	{ data: function(callback){

        		edit = `<button class="btn btn-default btn-sm pull-right" data-pc='{{ $workstation->id }}' data-software='`+ callback.id +`' data-target='#updateSoftwareWorkstationModal' data-toggle='modal'>Change License</button>`
        		button = `<button class="remove btn btn-danger btn-sm pull-right" data-pc='{{ $workstation->id }}' data-software="`+ callback.id +`">Uninstall</button>`

        		try
        		{
        			return `Installed:  ` + " " + callback.pcsoftware.softwarelicense.key + edit + button
        		} catch (e) {
        			try {
        				if(!callback.pcsoftware.isEmpty)
        				return `Installed` + edit + button
        			} catch (e) {
        				return "<i>Not Installed</i>  <button class='install btn btn-success btn-sm pull-right' data-pc='{{ $workstation->id }}' data-software='"+ callback.id +"' data-target='#installSoftwareWorkstationModal' data-toggle='modal'>Install</button>"
        			}
        		}
        	}}
        ],
    } );

    $('#softwareTable').on('click','.remove',function(){
    	pc = $(this).data('pc')
    	software = $(this).data('software')

    	$.ajax({
    		type: 'delete',
    		url: '{{ url("workstation/software/$workstation->id/remove") }}',
    		data: {
    			'software': software
    		},
    		dataType: 'json',
    		success: function(response){
    			if(response == 'success')
    				swal('Operation Success','','success')
    			else
    				swal('Error occurred while processing your request','','error')

    			table.ajax.reload()
    			historyTable.ajax.reload()
    		}
    	})

    })

    $('#installSoftwareWorkstationModal').on('hide.bs.modal',function(){
    	table.ajax.reload()
		historyTable.ajax.reload()
    })

    $('#updateSoftwareWorkstationModal').on('hide.bs.modal',function(){
    	table.ajax.reload()
		historyTable.ajax.reload()
    })

	@if( Session::has("success-message") )
	  swal("Success!","{{ Session::pull('success-message') }}","success");
	@endif
	@if( Session::has("error-message") )
	  swal("Oops...","{{ Session::pull('error-message') }}","error");
	@endif

	$('#page-body').show()
})
</script>
@stop
