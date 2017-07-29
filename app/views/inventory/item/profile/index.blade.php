@extends('layouts.master-blue')
@section('title')
Inventory
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
{{ HTML::style(asset('css/select.bootstrap.min.css')) }}
{{ HTML::style(asset('css/style.min.css')) }}
<style>
	#page-body{
		display: none;
	}

	a > hover{
		text-decoration: none;
	}

	th , tbody{
		text-align: center;
	}
</style>
@stop
@section('script-include')
<script src="{{ asset('js/jQuery.succinct.min.js') }}"></script>
@stop
@section('content')
<div class="container-fluid" id="page-body">
@include('modal.inventory.item.assign')
	<div class="col-md-12">
		<div class="panel panel-body table-responsive">
			<ol class="breadcrumb">
			  <li><a href="{{ url('inventory/item') }}">Item Inventory</a></li>
			  <li class="active">{{{ $inventory->model }}}</li>
			</ol>
			<legend><h3 class="text-muted">{{ $inventory->brand }} {{ $inventory->model }}</h3></legend>
			<table class="table table-hover table-striped table-bordered table-condensed" id="itemProfileTable">
				<thead>
					<th>ID</th>
					<th>Property Number</th>
					<th>Serial Number</th>
					<th>Location</th>
					<th>Date Received</th>
					<th>Status</th>
				</thead>
			</table>
		</div>
	</div>
</div>
@stop
@section('script')
{{ HTML::script(asset('js/dataTables.select.min.js')) }}
{{ HTML::script(asset('js/moment.min.js')) }}
<script type="text/javascript">
	$(document).ready(function() {

		var table = $('#itemProfileTable').DataTable({
			"pageLength": 100,
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
				ajax: "{{ url("item/profile/$inventory->id") }}",
				columns: [
						{ data: "id" },
						{ data: "propertynumber" },
						{ data: "serialnumber" },
						{ data: "location" },
						{data: function(callback){
							return moment(callback.datereceived).format("dddd, MMMM Do YYYY");
						}},
						{ data: "status" }
				],
		});

		$("div.toolbar").html(`
			  	<button class="btn btn-success btn-flat" data-toggle="modal" data-target="#assignModal" id="assign" style="padding:10px;">
			  		<span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span> Assign
			  	</button>
				<div class="btn-group">
							<button id="delete" class="btn btn-danger btn-flat" type="button" style="padding:10px">
								<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
								<span class="hidden-sm hidden-xs">Condemn</span>
							</button>
				</div>
		`);

		$('#assign').on('click',function(){
			$('#assign-item').val(table.row('.selected').data().id)
		})

		$('#edit').on('click',function(){
			try{
				if(table.row('.selected').data().id != null && table.row('.selected').data().id  && table.row('.selected').data().id >= 0)
				{
					// $('#updateFacultyModal').modal('show');
						window.location.href = "{{ url('item/profile') }}" + '/' + table.row('.selected').data().id + '/edit'
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
			          text: "This record will be considered as condemned and will be removed. Do you want to continue?",
			          type: "warning",
  					  confirmButtonColor: "#DD6B55",
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
							url: '{{ url("item/profile/") }}' + "/" + table.row('.selected').data().id,
							data: {
								'id': table.row('.selected').data().id
							},
							dataType: 'json',
							success: function(response){
								if(response == 'success'){
									swal('Operation Successful','Item condemned','success')
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
