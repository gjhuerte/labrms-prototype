@extends('layouts.master-blue')
@section('title')
Tickets
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
{{ HTML::style(asset('css/select.bootstrap.min.css')) }}
<link rel="stylesheet" href="{{ url('css/style.css') }}"  />
<style>
	#page-body{
		display: none;
	}

	.toolbar {
    	float:left;
	}

	textarea{
		resize:none;
		overflow-y:hidden;
	}
</style>
@stop
@section('content')
@include('modal.ticket.create')
<div class="container-fluid" id="page-body">
	<div class="col-md-12" id="workstation-info">
		<div class="panel panel-body table-responsive" style="padding: 25px 30px;">
			<legend class="text-muted">Open Tickets</legend>
			<table class="table table-hover table-bordered" id="ticketTable">
				<thead>
					<th>ID</th>
					<th>Details</th>
					<th>Type</th>
					<th>Assigned To</th>
					<th>Author</th>
					<th>Status</th>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>
</div>
@stop
@section('script')
{{ HTML::script(asset('js/dataTables.select.min.js')) }}
<script type="text/javascript">
	$(document).ready(function() {

		@if( Session::has("success-message") )
		  swal("Success!","{{ Session::pull('success-message') }}","success");
		@endif
		@if( Session::has("error-message") )
		  swal("Oops...","{{ Session::pull('error-message') }}","error");
		@endif

  	var table = $('#ticketTable').DataTable({
  		select: {
  			style: 'single'
  		},
	    language: {
	        searchPlaceholder: "Search..."
	    },
    	"dom": "<'row'<'col-sm-6'<'toolbar'>><'col-sm-3 text-center'><'col-sm-3'f>>" +
					    "<'row'<'col-sm-12'tr>>" +
					    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
			"processing": true,
      ajax: "{{ url('ticket') }}",
      columns: [
          { data: "id" },
          { data: "details" },
          { data: "tickettype" },
          { data: function(callback){
          	return callback.user.firstname + " " + callback.user.lastname;
          } },
          { data: "author" },
          { data: function(callback){
          	var status = parseInt(callback.status);
          	if(status == 0)
          	return 'Open';
          	else if(status == 1)
          	return 'Close';
          } }
    	],
  	});



    $('#table tbody').on( 'click', 'tr', function () {
      if ( $(this).hasClass('selected') ) {
          $(this).removeClass('selected');
      }
      else {
          table.$('tr.selected').removeClass('selected');
          $(this).addClass('selected');
      }
    } );

 	$("div.toolbar").html(`
			<button id="add" class="btn btn-primary btn-flat" style="margin-right:5px;padding: 5px 10px;"><span class="glyphicon glyphicon-plus"></span>  New</button>
			<a id="closed" class="btn btn-default btn-flat" style="margin-right:5px;padding: 6px 10px;"><span class="glyphicon glyphicon-off"></span> Closed</a>
			<button id="assign" class="btn btn-success btn-flat" style="margin-right:5px;padding: 5px 10px;"><span class="glyphicon glyphicon-share-alt"></span> Assign</button>
			<button id="close" class="btn btn-danger btn-flat" style="margin-right:5px;padding: 5px 10px;"><span class="glyphicon glyphicon-trash"></span> Close</button>
			<button id="resolve" class="btn btn-info btn-flat" style="margin-right:5px;padding: 5px 10px;"><span class="glyphicon glyphicon-check"></span> Resolve</button>
	`);

	$('#add').on('click',function(){
		window.location.href = '{{ url('ticket/create') }}';
	});

    $('#edit').click( function () {
			try{
				if(table.row('.selected').data().id != null && table.row('.selected').data().id  && table.row('.selected').data().id >= 0)
				{
	        window.location.href = "{{ url('ticket/') }}" + "/" + table.row('.selected').data().id + "/edit";
				}
			}catch( error ){
				swal('Oops..','You must choose atleast 1 row','error');
			}
    } );

    $('#assign').click( function () {
			try{
				if(table.row('.selected').data().id != null && table.row('.selected').data().id  && table.row('.selected').data().id >= 0)
				{

				}
			}catch( error ){
				swal('Oops..','You must choose atleast 1 row','error');
			}
    } );

    $('#resolve').click( function () {
		try{
			if(table.row('.selected').data().id != null && table.row('.selected').data().id  && table.row('.selected').data().id >= 0)
			{

			}
		}catch( error ){
			swal('Oops..','You must choose atleast 1 row','error');
		}
    } );

    $('#close').click( function () {
			try{
				if(table.row('.selected').data().id != null && table.row('.selected').data().id  && table.row('.selected').data().id >= 0)
				{
					$.ajax({
						type: 'delete',
						url: '{{ url("ticket") }}' + "/" + table.row('.selected').data().id,
						data: {
							'id': table.row('.selected').data().id
						},
						dataType: 'json',
						success: function(response){
							if(response.length > 0){
								swal('Operation Successful','Ticket has been closed','success')
				        table.row('.selected').remove().draw( false );
							}else{
								swal('Operation Unsuccessful','Error occurred while closing a ticket','error')
							}
						},
						error: function(){
							swal('Operation Unsuccessful','Error occurred while closing a ticket','error')
						}
					});
				}
			}catch( error ){
				swal('Oops..','You must choose atleast 1 row','error');
			}
    } );

	$('#page-body').show();
  });
</script>
@stop
