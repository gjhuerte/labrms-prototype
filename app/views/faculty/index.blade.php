@extends('layouts.master-blue')
@section('title')
Faculty
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('script-include')
<script type="text/javascript" src="{{ asset('js/jquery.validate.min.js') }}"></script>
@stop
@section('style')
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
	@include('modal.faculty.create')
	@include('modal.faculty.edit')
	<div class="col-md-12" id="faculty-info">
		<div class="col-sm-12 panel panel-body  table-responsive">
			<table id='facultyTable' class="table table-hover table-striped table-condensed table-bordered">
				<thead>
					<th>ID</th>
					<th>Identification Number</th>
					<th>Lastname</th>
					<th>Firstname</th>
					<th>Middlename</th>
					<th>Email</th>
					<th>Contact Number</th>
					<th>Role</th>
				</thead>
			</table>
		</div>
	</div>
</div>
@stop
@section('script')
{{ HTML::script(asset('js/dataTables.select.min.js')) }}
<script>
	$(document).ready(function() {

	    var table = $('#facultyTable').DataTable( {
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
	        ajax: "{{ url('faculty') }}",
	        columns: [
	            { data: "id" },
	            { data: "username" },
	            { data: "lastname" },
	            { data: "firstname" },
	            { data: "middlename" },
	            { data: "email" },
	            { data: "contactnumber" },
	            { data: function(param){
	            	if(param.accesslevel == '0')
	            		return 'Laboratory Head';
	            	else if(param.accesslevel == '1')
	            		return 'Laboratory Assistant';
	            	else if(param.accesslevel == '2')
	            		return 'Laboratory Staff';
	            	else if(param.accesslevel == '3')
	            		return 'Laboratory Assistant';
	            	else if(param.accesslevel == '4')
	            		return 'Faculty';
	            	else if(param.accesslevel == '5')
	            		return 'Student';
	            } },
	        ],
	    } );

	 	$("div.toolbar").html(`
 			<button id="new" class="btn btn-primary btn-flat" style="margin-right:5px;padding: 5px 10px;" data-target="createFacultyModal" data-toggle="modal"><span class="glyphicon glyphicon-plus"></span>  Add</button>
 			<button id="edit" class="btn btn-default btn-flat" style="margin-right:5px;padding: 6px 10px;"><span class="glyphicon glyphicon-pencil"></span>  Update</button>
 			<button id="delete" class="btn btn-danger btn-flat" style="margin-right:5px;padding: 5px 10px;"><span class="glyphicon glyphicon-trash"></span> Remove</button>
		`);

	    $('#table tbody').on( 'click', 'tr', function () {
	      if ( $(this).hasClass('selected') ) {
	          $(this).removeClass('selected');
	      }
	      else {
	          table.$('tr.selected').removeClass('selected');
	          $(this).addClass('selected');
	      }
	    } );

		$('#new').on('click',function(){
			$('#createFacultyModal').modal('show');
		})

		$('#edit').on('click',function(){
			try{
				if(table.row('.selected').data().id != null && table.row('.selected').data().id  && table.row('.selected').data().id >= 0)
				{
					$('#update-id').val(table.row('.selected').data().id);
					$('#update-username').val(table.row('.selected').data().username);
					$('#update-lastname').val(table.row('.selected').data().lastname);
					$('#update-firstname').val(table.row('.selected').data().firstname);
					$('#update-middlename').val(table.row('.selected').data().middlename);
					$('#update-email').val(table.row('.selected').data().email);
					$('#update-contactnumber').val(table.row('.selected').data().contactnumber);
					$('#update-id').val(table.row('.selected').data().id);
					$('#updateFacultyModal').modal('show');
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
			          text: "This faculty will be removed from database?",
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
							url: '{{ url("faculty/") }}' + "/" + table.row('.selected').data().id,
							data: {
								'id': table.row('.selected').data().id
							},
							dataType: 'json',
							success: function(response){
								if(response == 'success'){
									swal('Operation Successful','Faculty removed from database','success')
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

		@if( Session::has("success-message") )
		  swal("Success!","{{ Session::pull('success-message') }}","success");
		@endif
		@if( Session::has("error-message") )
		  swal("Oops...","{{ Session::pull('error-message') }}","error");
		@endif

		$('#page-body').show();
	} );
</script>
@stop
