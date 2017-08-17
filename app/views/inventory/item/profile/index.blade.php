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
	#page-body,#assign,#delete{
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
			<legend><h3 class="text-muted">{{ $inventory->itemtype->name }} Inventory</h3></legend>
			<p class="text-muted">Note: Actions will be shown when a row has been selected</p>	
			<table class="table table-hover table-striped table-bordered table-condensed" id="itemProfileTable" cellspacing="0" width="100%">
				<thead>
		          <tr rowspan="2">
		              <th class="text-left" colspan="3">Brand:  
		                <span style="font-weight:normal">{{ $inventory->brand }}</span> 
		              </th>
		              <th class="text-left" colspan="3">Model:  
		                <span style="font-weight:normal">{{ $inventory->model }}</span> 
		              </th>
		          </tr>
		          <tr rowspan="2">
		              <th class="text-left" colspan="3">Item Type:  
		                <span style="font-weight:normal">{{ $inventory->itemtype->name }}</span>  
		              </th>
		              <th class="text-left" colspan="3"> 
		              </th>
		          </tr>
		          	<tr>
						<th>ID</th>
						<th>Property Number</th>
						<th>Serial Number</th>
						<th>Location</th>
						<th>Date Received</th>
						<th>Status</th>
					</tr>
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
			select: {
				style: 'single'
			},
			language: {
					searchPlaceholder: "Search..."
			},
	    	"dom": "<'row'<'col-sm-2'l><'col-sm-7'<'toolbar'>><'col-sm-3'f>>" +
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
 
	    table
	        .on( 'select', function ( e, dt, type, indexes ) {
	            // var rowData = table.rows( indexes ).data().toArray();
	            // events.prepend( '<div><b>'+type+' selection</b> - '+JSON.stringify( rowData )+'</div>' );
	            $('#assign').show()
	            $('#delete').show()
	        } )
	        .on( 'deselect', function ( e, dt, type, indexes ) {
	            // var rowData = table.rows( indexes ).data().toArray();
	            // events.prepend( '<div><b>'+type+' <i>de</i>selection</b> - '+JSON.stringify( rowData )+'</div>' );
	            $('#assign').hide()
	            $('#delete').hide()
	        } );

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
					        	}else if(response == 'connected'){
									swal('Operation Unsuccessful','This item is used in a workstation. You cannot remove it here. You need to proceed to workstation','error')
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
