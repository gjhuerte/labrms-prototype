@extends('layouts.master-blue')
@section('title')
Items for Reservation
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
@include('modal.reservation.items.add')
<div class="container-fluid" id="page-body">
	<div class="col-md-12" id="workstation-info">
		<div class="panel panel-body table-responsive" style="padding: 25px 30px;">
			<table class="table table-hover table-bordered" id="reservationRulesTable">
				<thead>
					<th>ID</th>
					<th>Item type</th>
					<th>Models - Brand</th>
					<th>Included</th>
					<th>Excluded</th>
					<th>Status</th>
				</thead>
				<tbody>
				</tbody>
			</table>
			<ul class="list-unstyled text-muted" style="font-size: 13px;">
				<li class="text-success">*If included column is filled, the items for reservation under the said column only consists of those items.</li>
				<li class="text-danger">*Items added to excluded column will not be allowed for student and faculty reservation.</li>
				<li class="text-warning">*You need to fill the model and brand section to tell the system that items on the said sections will be included in the reservation</li>
				<li class="text-primary">*If you dont want a rule to apply, you can set the status to disabled. By default, the status is set to Enabled</li>
			</ul>
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

  	var table = $('#reservationRulesTable').DataTable({
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
      ajax: "{{ url('get/reservation/items/list/all') }}",
      columns: [
          { data: "id" },
          { data: "name" },
          { data: function(param){
          	return param.model + " - " + param.brand;
          }},
          { data: "included" },
          { data: "excluded" },
          {
			data: "status",
			name: 'status'
		  },
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
		<button id="add" class="btn btn-primary btn-flat" style="margin-right:5px;padding: 5px 10px;" data-target="reservationItemsAddModal" data-toggle="modal"><span class="glyphicon glyphicon-plus"></span>  New</button>
		<button id="edit" class="btn btn-default btn-flat" style="margin-right:5px;padding: 6px 10px;"><span class="glyphicon glyphicon-pencil"></span>  Edit</button>
		<button id="delete" class="btn btn-danger btn-flat" style="margin-right:5px;padding: 5px 10px;"><span class="glyphicon glyphicon-trash"></span> Delete</button>
		<button id="enable" class="btn btn-info btn-flat" style="margin-right:5px;padding: 5px 10px;"><span class="glyphicon glyphicon-check"></span> Enable / Disable</button>
	`);

	$('#add').on('click',function(){
		$('#reservationItemsAddModal').modal('show');
	});

    $('#edit').click( function () {
			try{
				if(table.row('.selected').data().id != null && table.row('.selected').data().id  && table.row('.selected').data().id >= 0)
				{
	        window.location.href = "{{ url('reservation/items/list/') }}" + "/" + table.row('.selected').data().id + "/edit";
				}
			}catch( error ){
				swal('Oops..','You must choose atleast 1 row','error');
			}
    } );

		$('#enable').on('click',function(){

			try{

					var id = table.row('.selected').data().id;
					if(table.row('.selected').data().status == 'Enabled'){
					swal({
						title: "Do you want to continue?",
						text: 'You will be now be disabling this rule ',
						type: "info",
						showCancelButton: true,
						closeOnConfirm: false,
						showLoaderOnConfirm: true
					}, function () {
						$.ajax({
							type:'post',
							url: '{{ url("update/reservation/items/list/status") }}' + '/' + id,
							data: {
								'id' : id
							},
							dataType: 'json',
							success: function(response){
								if(response == 'success'){
									table.cell(table.row('.selected').index(),5).data('Disabled');
									swal('Operation Completed','Rule Disabled','success')
								}else{
									swal('Server Error','Reload this page before proceeding','error')
								}

							},
							error: function(){
								swal('Error Occurred!','Theres a problem sending your data','error');
							}
						})
					});

					}else{

						swal({
							title: "Do you want to continue?",
							text: 'You will be now enabling this rule',
							type: "info",
							showCancelButton: true,
							closeOnConfirm: false,
							showLoaderOnConfirm: true
						}, function () {
							$.ajax({
								type:'post',
								url: '{{ url("update/reservation/items/list/status") }}' + '/' + id,
								data: {
									'id' : id
								},
								dataType: 'json',
								success: function(response){
									if(response == 'success'){
										table.cell(table.row('.selected').index(),5).data('Enabled');
										swal('Operation Completed','Rule Enabled','success')
									}else{
										swal('Server Error','Reload this page before proceeding','error')
									}

								},
								error: function(){
									swal('Error Occurred!','Theres a problem sending your data','error');
								}
							})
						});
					}
			}catch(err){
				swal('Oops..','You must choose atleast 1 row','error');
			}

		});

    $('#delete').click( function () {
			try{
				if(table.row('.selected').data().id != null && table.row('.selected').data().id  && table.row('.selected').data().id >= 0)
				{
					$.ajax({
						type: 'delete',
						url: '{{ url("reservation/items/list") }}' + "/" + table.row('.selected').data().id,
						data: {
							'id': table.row('.selected').data().id
						},
						dataType: 'json',
						success: function(response){
							if(response.length > 0){
								swal('Operation Successful','An item filter for reservation has been deleted','success')
				        table.row('.selected').remove().draw( false );
							}else{
								swal('Operation Unsuccessful','Error occurred while deleting a record','error')
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
    } );

		jQuery.each(jQuery('textarea[data-autoresize]'), function() {
		    var offset = this.offsetHeight - this.clientHeight;

		    var resizeTextarea = function(el) {
		        jQuery(el).css('height', 'auto').css('height', el.scrollHeight + offset);
		    };
		    jQuery(this).on('keyup input', function() { resizeTextarea(this); }).removeAttr('data-autoresize');
		});

		$('#page-body').show();
  });
</script>
@stop
