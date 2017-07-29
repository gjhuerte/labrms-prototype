	@extends('layouts.master-blue')
@section('title')
Software
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
{{ HTML::style(asset('css/bootstrap-multiselect.css')) }}
{{ HTML::style(asset('css/select.bootstrap.min.css')) }}
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
<style>
	#page-body{
		display: none;
	}
</style>
@stop
@section('content')
<div class="container-fluid" id="page-body">
	@include('modal.software.create')
	@include('modal.software.edit')
	@include('modal.software.assign')
	<div class="col-md-12" id="room-info">
		<div class="panel panel-body table-responsive" style="padding: 20px">
			<table class="table table-hover table-striped table-bordered" id='softwareTable'>
				<thead>
					<th>ID</th>
					<th>Software name</th>
					<th>Company</th>
					<th>License type</th>
					<th>Software type</th>
					<th>Minimum Requirements</th>
					<th>Maximum Requirements</th>
					<th>Room/s Assigned</th>
					<th class="no-sort"></th>
				</thead>
			</table>
		</div>
	</div>
</div>
@stop
@section('script')
{{ HTML::script(asset('js/bootstrap-multiselect.js')) }}
{{ HTML::script(asset('js/dataTables.select.min.js')) }}
<script type="text/javascript">
	$(document).ready(function(){
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
	    	"dom": "<'row'<'col-sm-9'<'toolbar'>><'col-sm-3'f>>" +
						    "<'row'<'col-sm-12'tr>>" +
						    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
			"processing": true,
	        ajax: "{{ url('software') }}",
	        columns: [
	            { data: "id" },
	            { data: "softwarename" },
	            { data: "company" },
	            { data: "licensetype" },
	            { data: "softwaretype" },
	            { data: "minsysreq" },
	            { data: "maxsysreq" },
	            { data: function(callback){
	            	htmllist = `<ul class="list-unstyled">`
	            	callback.roomsoftware.forEach(function(element){
	            		htmllist += `<li class="col-xs-12">` + element.room.name + ` <button class="remove btn btn-danger btn-xs" data-id="`+ callback.id +`" data-room="`+ element.room.id +`"><span class="glyphicon glyphicon-remove"></span></button></li>`
	            	})
	            	htmllist += `</ul>`
	            	return htmllist;
	            } },
	            { data: function(callback){
	          		return "<a href='{{ url("software/license") }}" + '/' +  callback.id + "' class='btn btn-sm btn-default btn-block'>View License</a>"
	          	} }
	        ],
	    } );

	 	$("div.toolbar").html(`
 			<button id="new" class="btn btn-primary btn-flat" style="margin-right:5px;padding: 5px 10px;" data-target="#createSoftwareModal" data-toggle="modal"><span class="glyphicon glyphicon-plus"></span>  Add</button>
 			<button id="edit" class="btn btn-default btn-flat" style="margin-right:5px;padding: 6px 10px;"><span class="glyphicon glyphicon-pencil"></span>  Update</button>
 			<button id="delete" class="btn btn-danger btn-flat" style="margin-right:5px;padding: 5px 10px;"><span class="glyphicon glyphicon-trash"></span> Remove</button>
 			<button id="assign" class="btn btn-warning btn-flat" style="margin-right:5px;padding: 5px 10px;"><span class="glyphicon"></span> Assign to a room</button>
		`);

		$('#edit').on('click',function(){
			try{
				if(table.row('.selected').data().id != null && table.row('.selected').data().id  && table.row('.selected').data().id >= 0)
				{
					$('#edit-id').val(table.row('.selected').data().id)
					$('#edit-name').val(table.row('.selected').data().softwarename)
					$('#edit-company').val(table.row('.selected').data().company)
					$('#edit-licensetype').val(table.row('.selected').data().licensetype)
					$('#edit-softwaretype').val(table.row('.selected').data().softwaretype)
					$('#edit-minrequirement').val(table.row('.selected').data().minsysreq)
					$('#edit-maxrequirement').val(table.row('.selected').data().maxsysreq)
					$('#updateSoftwareModal').modal('show');
				}
			}catch( error ){
				swal('Oops..','You must choose atleast 1 row','error');
			}
		});

		$('#assign').on('click',function(){
			try{
				if(table.row('.selected').data().id != null && table.row('.selected').data().id  && table.row('.selected').data().id >= 0)
				{
					$('#assign-software').val(table.row('.selected').data().id)
					$('#assign-room').data('room',table.row('.selected').data().roomsoftware)
					$('#assignSoftwareModal').modal('show');
					$('#assignSoftwareModal').on('hide.bs.modal',function(){
					table.ajax.reload()
					})
				}
			}catch( error ){
				console.log(error)
				swal('Oops..','You must choose atleast 1 row','error');
			}
		});

	    $('#delete').on('click',function(){
			try{
				if(table.row('.selected').data().id != null && table.row('.selected').data().id  && table.row('.selected').data().id >= 0)
				{
			        swal({
			          title: "Are you sure?",
			          text: "This software will be removed. Do you want to continue?",
			          type: "warning",
			          showCancelButton: true,
			          confirmButtonText: "Yes, delete it!",
			          cancelButtonText: "No, cancel it!",
			          closeOnConfirm: false,
			          closeOnCancel: false
			        },
			        function(isConfirm){
			          if (isConfirm) {
     					$.ajax({
							type: 'delete',
							url: '{{ url("software/") }}' + "/" + table.row('.selected').data().id,
							dataType: 'json',
							success: function(response){
								if(response == 'success'){
									swal('Operation Successful','Software removed','success')
					        		table.row('.selected').remove().draw( false );
					        	}else{
									swal('Operation Unsuccessful','Error occurred while deleting a record','error')
								}
							},
							error: function(){
								swal('Operation Unsuccessful','Error occurred while deleting a record','error')
							}
						});
			          } else {
			            swal("Cancelled", "Operation Cancelled", "error");
			          }
			        })
				}
			}catch( error ){
				swal('Oops..','You must choose atleast 1 row','error');
			}
	    });

	    $('#softwareTable').on('click','.remove',function()
	    {
	    	$.ajax({
	    		type: 'post',
	    		url: '{{ url("software/room/remove") }}' + '/' + $(this).data('id') + '/' + $(this).data('room'),
	    		dataType: 'json',
	    		success: function(response){
	    			if(response == 'success') swal('Operation Success','Software unlink from room','success')
	    			else swal('Operation Failed','Problem occurred while processing data. Please reload the page','error')
	    			table.ajax.reload()
	    		}
	    	})
	    })

	    $('#table tbody').on( 'click', 'tr', function () {
	      if ( $(this).hasClass('selected') ) {
	          $(this).removeClass('selected');
	      }
	      else {
	          table.$('tr.selected').removeClass('selected');
	          $(this).addClass('selected');
	      }
	    } );

		@if( Session::has("success-message") )
		swal("Success!","{{ Session::pull('success-message') }}","success");
		@endif
		@if( Session::has("error-message") )
		swal("Oops...","{{ Session::pull('error-message') }}","error");
		@endif

		$('#page-body').show();
	});
</script>
@stop
