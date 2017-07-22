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
<div class="container-fluid" id="page-body">
@include('modal.ticket.create')
@include('modal.ticket.transfer')
	<div class="col-md-12" id="workstation-info">
		<div class="panel panel-body table-responsive" style="padding: 25px 30px;">
			<legend class="text-muted">Open Tickets</legend>
			<table class="table table-hover table-bordered" id="ticketTable">
				<thead>
					<th>ID</th>
					<th>Property Number</th>
					<th>Details</th>
					<th>Type</th>
					<th>Assigned To</th>
					<th>Author</th>
					<th>Status</th>
					<th>Date Created</th>
					<th class="no-sort"></th>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>
</div>
@stop
@section('script')
{{ HTML::script(asset('js/moment.min.js')) }}
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
  		    order: [[ 7, "desc" ]],
	  		select: {
	  			style: 'single'
	  		},
		    language: {
		        searchPlaceholder: "Search..."
		    },
	    	columnDefs:[
				{ targets: 'no-sort', orderable: false },
	    	],
	    	"dom": "<'row'<'col-sm-6'<'toolbar'>><'col-sm-3 text-center'><'col-sm-3'f>>" +
						    "<'row'<'col-sm-12'tr>>" +
						    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
				"processing": true,
	      ajax: "{{ url('ticket') }}",
	      columns: [
	          { data: "id" },
	          { data: "itemprofile.propertynumber" },
	          { data: "details" },
	          { data: "tickettype" },
	          { data: function(callback){
	          	return callback.user.firstname + " " + callback.user.lastname;
	          } },
	          { data: "author" },
	          { data: "status"},
	          {
            	data: function(callback){
            		return moment(callback.created_at).format("dddd, MMMM Do YYYY, h:mm a");
            	} 
	           },
	          { data: function(callback){
	          	return "<a href='{{ url("ticket/history") }}" + '/' +  callback.id + "' class='btn btn-sm btn-default btn-block'>View History</a>"
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
				<button id="add" class="btn btn-primary btn-flat" style="margin-right:5px;padding: 5px 10px;"><span class="glyphicon glyphicon-plus"></span>  Create</button>	
				<button id="assign" class="btn btn-success btn-flat" style="margin-right:5px;padding: 5px 10px;"><span class="glyphicon glyphicon-share-alt"></span> Assign | Transfer</button>
				<button id="close" class="btn btn-danger btn-flat" style="margin-right:5px;padding: 5px 10px;"><span class="glyphicon glyphicon-off"></span> Close</button>
				<button id="resolve" class="btn btn-info btn-flat" style="margin-right:5px;padding: 5px 10px;"><span class="glyphicon glyphicon-check"></span> Resolve</button>
		`);

		$('#add').on('click',function(){
			window.location.href = '{{ url('ticket/create') }}';
		});

	    $('#assign').click( function () {
				try{
					if(table.row('.selected').data().id != null && table.row('.selected').data().id  && table.row('.selected').data().id >= 0)
					{
						$('#transfer-id').val(table.row('.selected').data().id)
						$('#transferTicketModal').modal('show')
					}
				}catch( error ){
					swal('Oops..','You must choose atleast 1 row','error');
				}
	    } );

	    $('#resolve').click( function () {
			try{
				if(table.row('.selected').data().id != null && table.row('.selected').data().id  && table.row('.selected').data().id >= 0)
				{
					if(table.row('.selected').data().tickettype == 'complaint')
					{
						swal({
						  title: "Action Taken",
						  text: "Details of the procedures / activities done",
						  type: "input",
						  showCancelButton: true,
						  closeOnConfirm: false,
						  animation: "slide-from-top",
						  inputPlaceholder: "Summary of action taken"
						},
						function(inputValue){
						  if (inputValue === false) return false;
						  
						  if (inputValue === "") {
						    swal.showInputError("You need to write something!");
						    return false
						  }

						  $.ajax({
						  	url: "{{ url('ticket/{id}/resolve') }}",
						  	type: 'POST',
						  	data: {
						  		'id' : table.row('.selected').data().id,
						  		'details': inputValue
						  	},
						  	dataType: 'json',
						  	success: function(response){
						  		if(response == 'success')
						  		{
						  			swal('Operation Success','Action has been created for this ticket','success')
						  			table.ajax.reload()
						  		}
						  	},
						  	error: function(){
					  			swal.close()
						  		swal('Error!','Theres a problem while parsing your data. Refresh your tab','error')
						  	}
						  })
						});
					} else {
						swal('Error!','Only complaints can be resolved','error')
					}
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
