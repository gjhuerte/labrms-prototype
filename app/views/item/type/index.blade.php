@extends('layouts.master-blue')
@section('title')
Item Types
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
{{ HTML::style(asset('css/select.bootstrap.min.css')) }}
<link rel="stylesheet" href="{{ asset('css/style.css') }}"  />
<style>
	#page-body,#edit,#delete{
		display:none;
	}
</style>
@stop
@section('content')
<div class="container-fluid" id="page-body">
	@include('modal.item.type.create')
	@include('modal.item.type.edit')
	<div class="col-md-12" id="itemtype-info">
		<div class="col-sm-12 panel panel-body  table-responsive">
			<legend><h3 class="text-muted">Item Types</h3></legend>
			<p class="text-muted">Note: Other actions will be shown when a row has been selected</p>
			<p class="text-muted">You can view all deleted item type <a href="{{ url('item/type/view/restore') }}">here</a></p>
			<table class="table table-striped table-hover table-bordered" id='itemTypeTable'>
				<thead>
					<th>ID</th>
					<th>Item type</th>
					<th>Description</th>
					<th>Category</th>
				</thead>
			</table>
		</div>
	</div>
</div>
@stop
@section('script')
{{ HTML::script(asset('js/dataTables.select.min.js')) }}
<script type="text/javascript">
	$(document).ready(function(){

		@if( Session::has("success-message") )
		  swal("Success!","{{ Session::pull('success-message') }}","success");
		@endif
		@if( Session::has("error-message") )
		  swal("Oops...","{{ Session::pull('error-message') }}","error");
		@endif


	    var table = $('#itemTypeTable').DataTable( {
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
	        ajax: "{{ url('item/type') }}",
	        columns: [
	            { data: "id" },
	            { data: "name" },
	            { data: "description" },
	            { data: "category" }
	        ],
	    } );

	 	$("div.toolbar").html(`
 			<button id="new" class="btn btn-primary btn-flat" style="margin-right:5px;padding: 5px 10px;" data-target="createItemTypeModal" data-toggle="modal"><span class="glyphicon glyphicon-plus"></span>  Add</button>
 			<button id="edit" class="btn btn-default btn-flat" style="margin-right:5px;padding: 6px 10px;"><span class="glyphicon glyphicon-pencil"></span>  Update</button>
 			<button id="delete" class="btn btn-danger btn-flat" style="margin-right:5px;padding: 5px 10px;"><span class="glyphicon glyphicon-trash"></span> Remove</button>
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
	    	// $('#createItemTypeModal').modal('show');
	    	window.location.href = "{{ url('item/type/create') }}"
	    })

		$('#edit').on('click',function(){
			try{
				if(table.row('.selected').data().id != null && table.row('.selected').data().id  && table.row('.selected').data().id >= 0)
				{
					window.location.href = 'type/' + table.row('.selected').data().id + '/edit';
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
			          text: "This Item Type will be removed from database?",
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
							url: '{{ url("item/type/") }}' + "/" + table.row('.selected').data().id,
							data: {
								'id': table.row('.selected').data().id
							},
							dataType: 'json',
							success: function(response){
								if(response == 'success'){
									swal('Operation Successful','Item Type removed from database','success')
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

		$('#page-body').show();

	});
</script>
@stop
