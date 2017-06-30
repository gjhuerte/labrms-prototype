@extends('layouts.master-blue')
@section('title')
Accounts
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
{{ HTML::style(asset('css/select.bootstrap.min.css')) }}
<link rel="stylesheet" href="{{ asset('css/style.min.css') }}" />
@stop
@section('content')
<div class="container-fluid" id="page-body" hidden>
	@include('modal.account.create')
	@include('modal.account.edit')
	@include('modal.account.access')
	<div class="col-sm-12 panel panel-default" id="account-info" style="padding-top: 20px;">
		<div class="col-sm-12 panel-body  table-responsive">
		<p class="text-muted">Note: You can restore removed accounts by clicking <a href="{{ url('account/view/deleted') }}" role="button">me</a>. <span class="text-danger">Be careful when restoring deleted accounts </span> 
		</p>
			<table id='userTable' class="table table-bordered table-hover table-striped table-condensed">
				<thead>
					<th>ID</th>
					<th>Username</th>
					<th>Lastname</th>
					<th>Firstname</th>
					<th>Middlename</th>
					<th>Email</th>
					<th>Mobile</th>
					<th>Type</th>
					<th>Privilege</th>
					<th>Status</th>
				</thead>
				<tbody></tbody>
			</table>
		</div>
	</div>
</div>
@stop
@section('script')
{{ HTML::script(asset('js/dataTables.select.min.js')) }}
<script>
	$(document).ready(function() {

		@if( Session::has("success-message") )
		  swal("Success!","{{ Session::pull('success-message') }}","success");
		@endif
		@if( Session::has("error-message") )
		  swal("Oops...","{{ Session::pull('error-message') }}","error");
		@endif
		
	  	var table = $('#userTable').DataTable({
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
			ajax: "{{ url('get/account/all') }}",
			columns: [
			  { data: "id" },
			  { data: "username" },
			  { data: "lastname" },
			  { data: "firstname" },
			  { data: "middlename" },
			  { data: "email" },
			  { data: "contactnumber" },
			  { data: "type" },
			  { data: function(param){
			  	if(param.accesslevel == 0){
			  		return 'Laboratory Head';
			  	}

			  	if(param.accesslevel == 1){
			  		return 'Laboratory Assistant';
			  	}


			  	if(param.accesslevel == 2){
			  		return 'Laboratory Staff';
			  	}


			  	if(param.accesslevel == 3){
			  		return 'Faculty';
			  	}

			  	if(param.accesslevel == 4){
			  		return 'Student';
			  	}
			  }},

			  { data: function(param){

			  	if(param.status == 0){
			  		return 'Inactive';
			  	}else{
			  		return 'Activated';
			  	}

			  }},
			],
    	});

	 	$("div.toolbar").html(`
 			<button id="new" class="btn btn-primary btn-flat" style="margin-right:5px;padding: 5px 10px;" data-target="reservationItemsAddModal" data-toggle="modal"><span class="glyphicon glyphicon-plus"></span>  New</button>
 			<button id="edit" class="btn btn-default btn-flat" style="margin-right:5px;padding: 6px 10px;"><span class="glyphicon glyphicon-pencil"></span>  Update</button>
 			<button id="access" class="btn btn-success btn-flat" style="margin-right:5px;padding: 5px 10px;"><span class="glyphicon glyphicon-task"></span> Change Access Level</button>
 			<button id="activate" class="btn btn-warning btn-flat" style="margin-right:5px;padding: 5px 10px;"><span class="glyphicon glyphicon-check"></span> Activate | Deactivate</button>
 			<button id="reset" class="btn btn-info btn-flat" style="margin-right:5px;padding: 5px 10px;"><span class="glyphicon glyphicon"></span> Reset Password</button>
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
	    	$('#createNewAccountModal').modal('show');
	    });

	    $('#edit').on('click',function(){
			try{
				if(table.row('.selected').data().id != null && table.row('.selected').data().id  && table.row('.selected').data().id >= 0)
				{
					$('#update-username').val(table.row('.selected').data().username);
					$('#update-lastname').val(table.row('.selected').data().lastname);
					$('#update-firstname').val(table.row('.selected').data().firstname);
					$('#update-middlename').val(table.row('.selected').data().middlename);
					$('#update-type').val(table.row('.selected').data().type);
					$('#update-email').val(table.row('.selected').data().email);
					$('#update-contactnumber').val(table.row('.selected').data().contactnumber);
					$('#update-id').val(table.row('.selected').data().id);
	    			$('#editAccountModal').modal('show');
				}
			}catch( error ){
				swal('Oops..','You must choose atleast 1 row','error');
			}
	    });

	    $('#access').on('click',function(){
			try{
				if(table.row('.selected').data().id != null && table.row('.selected').data().id  && table.row('.selected').data().id >= 0)
				{
					$('#accesslevel-id').val(table.row('.selected').data().id)
					$('#accesslevel-name').val(table.row('.selected').data().firstname + " " + 
					table.row('.selected').data().middlename + " " + 
					table.row('.selected').data().lastname)
					$('#accesslevel-oldaccesslevel').val(
						function(){
						  	if(table.row('.selected').data().accesslevel == 0){
						  		return 'Laboratory Head';
						  	}

						  	if(table.row('.selected').data().accesslevel == 1){
						  		return 'Laboratory Assistant';
						  	}


						  	if(table.row('.selected').data().accesslevel == 2){
						  		return 'Laboratory Staff';
						  	}


						  	if(table.row('.selected').data().accesslevel == 3){
						  		return 'Faculty';
						  	}

						  	if(table.row('.selected').data().accesslevel == 4){
						  		return 'Student';
						  	}
						})
	    			$('#changeAccessLevelModal').modal('show');
				}
			}catch( error ){
				swal('Oops..','You must choose atleast 1 row','error');
			}
	    });

	    $('#activate').on('click',function(){
			try{
				if(table.row('.selected').data().id != null && table.row('.selected').data().id  && table.row('.selected').data().id >= 0)
				{
 					$.ajax({
						type: 'post',
						url: '{{ url("account/activate") }}' + "/" + table.row('.selected').data().id,
						data: {
							'type': function(){
								if ( table.row('.selected').data().status == 1 )
								{
									return 'deactivate';
								}else{
									return 'activate';
								}
							}
						},
						dataType: 'json',
						success: function(response){
							if(response == 'activated'){
								swal('Operation Successful','Account activated','success')
								table.ajax.reload();
							}else if(response == 'deactivated'){
								swal('Operation Successful','Account deactivated','success')
								table.ajax.reload();
							}else if(response == 'self'){
									swal('Operation Unsuccessful','You cannot change your own accounts status','error')
							}else{
								swal('Operation Unsuccessful','Error occurred while changing a records status','error')
							}
						},
						error: function(){
							swal('Operation Unsuccessful','Error occurred while deleting a record','error')
						}
					});
				}
			}catch( error ){
				swal('Oops..','You must choose atleast 1 row','error');
			}
	    });

	    $('#reset').on('click',function(){

	        swal({
	          title: "Are you sure?",
	          text: "This will reset this accounts password to the default '12345678'?",
	          type: "warning",
	          showCancelButton: true,
	          confirmButtonText: "Yes, reset it!",
	          cancelButtonText: "No, cancel it!",
	          closeOnConfirm: false,
	          closeOnCancel: false
	        },
	        function(isConfirm){
	          if (isConfirm) {
					$.ajax({
					type: 'post',
					url: '{{ url("account/password/reset") }}',
					data: {
						'id': table.row('.selected').data().id
					},
					dataType: 'json',
					success: function(response){
						if(response == 'success'){
							swal('Operation Successful','Password has been reset','success')
						}else{
							swal('Operation Unsuccessful','Error occurred while resetting the password','error')
						}
					},
					error: function(){
						swal('Operation Unsuccessful','Error occurred while resetting the password','error')
					}
				});
	          } else {
	            swal("Cancelled", "Operation Cancelled", "error");
	          }
	        })
	    });

	    $('#delete').on('click',function(){
			try{
				if(table.row('.selected').data().id != null && table.row('.selected').data().id  && table.row('.selected').data().id >= 0)
				{
			        swal({
			          title: "Are you sure?",
			          text: "Account will be removed from database?",
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
							url: '{{ url("account/") }}' + "/" + table.row('.selected').data().id,
							data: {
								'id': table.row('.selected').data().id
							},
							dataType: 'json',
							success: function(response){
								if(response == 'success'){
									swal('Operation Successful','Account removed from database','success')
					        		table.row('.selected').remove().draw( false );
					        	}else if(response == 'invalid'){
									swal('Operation Unsuccessful','You need to have atleast one account','error')
								}else if(response == 'self'){
									swal('Operation Unsuccessful','You cannot remove your own account','error')
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

		$('#page-body').show();
	} );
</script>
@stop
