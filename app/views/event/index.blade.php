@extends('layouts.master-blue')
@section('title')
Event
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
{{ HTML::style(asset('css/select.bootstrap.min.css')) }}
<link rel="stylesheet" href="{{ url('css/style.css') }}"  />
<style>
	#page-body,#edit,#delete{
		display: none;
	}
</style>
@stop
@section('content')
<div class="container-fluid" id="page-body">
	<div class="col-md-12" id="holiday-info">
		<div class="panel panel-body  table-responsive">
			<legend><h3 class="text-muted">Event</h3></legend>
			<p class="text-muted">Note: Other actions will be shown when a row has been selected</p>
				<table class="table table-hover table-striped table-bordered" id="eventTable">
					<thead>
						<th>ID</th>
						<th>Title</th>
						<th>Date</th>
						<th>Repeating</th>
					</thead>
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

    	var table = $('#eventTable').DataTable( {
			"pageLength": 50,
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
	        ajax: "{{ url('event') }}",
	        columns: [
	        	{ data: 'id' },
	            { data: 'title' },
	            {
            		data: function(callback){
            			return moment(callback.date).format("dddd, MMMM Do YYYY");
            	} },
	            { data: function(callback){
	            	if(callback.repeating)
	            	{
	            		return callback.repeatingFormat;
	            	} else {
	            		return "";
	            	}
	            } },
	        ],
	    } );

	 	$("div.toolbar").html(`

	 			<a id="new" class="btn btn-primary btn-flat" style="margin-right:5px;padding: 5px 10px;" href="{{ url('event/create') }}">
	 				<span class="glyphicon glyphicon-plus"></span>  Create
	 			</a>
	 			<button id="edit" class="btn btn-default btn-flat" style="margin-right:5px;padding: 5px 10px;">
	 				<span class="glyphicon glyphicon-pencil"></span>  Edit
	 			</button>
	 			<button id="delete" class="btn btn-danger btn-flat" style="margin-right:5px;padding: 5px 10px;">
	 				<span class="glyphicon glyphicon-trash"></span> Remove
	 			</button>
		`);
 
    table
        .on( 'select', function ( e, dt, type, indexes ) {
            // var rowData = table.rows( indexes ).data().toArray();
            // events.prepend( '<div><b>'+type+' selection</b> - '+JSON.stringify( rowData )+'</div>' );
            $('#edit').show()
            $('#delete').show()
        } )
        .on( 'deselect', function ( e, dt, type, indexes ) {
            // var rowData = table.rows( indexes ).data().toArray();
            // events.prepend( '<div><b>'+type+' <i>de</i>selection</b> - '+JSON.stringify( rowData )+'</div>' );
            $('#edit').hide()
            $('#delete').hide()
        } );

		$('#delete').on('click',function(){
			try{
				if(table.row('.selected').data().id != null && table.row('.selected').data().id  && table.row('.selected').data().id >= 0)
				{
					var array = [];
					table.rows('.selected').every(function(row) {
						array.push(table.row(row).data().id)
					})   

					$('#selected').val(array);
				}
			}catch( error ){
				swal('Oops..','You must choose atleast 1 row','error');
			}
		})

		$('#edit').on('click',function(){
			try{
				if(table.row('.selected').data().id != null && table.row('.selected').data().id  && table.row('.selected').data().id >= 0)
				{
					window.location.href = "{{ url('event') }}" + '/' + table.row('.selected').data().id + '/edit';
				}
			}catch( error ){
				swal('Oops..','You must choose atleast 1 row','error');
			}
		});

	    $('#delete').on('click',function(){
			try{
				if(table.row('.selected').data().id != null && table.row('.selected').data().id  && table.row('.selected').data().id >= 0)
				{
			        swal({
			          title: "Are you sure?",
			          text: "Do you really want to delete this holiday?",
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
							url: '{{ url("event") }}' + "/" + table.row('.selected').data().id,
							data: {
								'selected': $('#selected').val()
							},
							dataType: 'json',
							success: function(response){
								if(response == 'success'){
									swal('Operation Successful','Holiday removed','success')
					        	}else{
									swal('Operation Unsuccessful','Error occurred while processing your request','error')
								}

								table.ajax.reload();
							},
							error: function(){
								swal('Operation Unsuccessful','Error occurred while processing your request','error')
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

		$('#page-body').show();
  	});
</script>
@stop
