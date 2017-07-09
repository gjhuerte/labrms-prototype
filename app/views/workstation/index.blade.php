@extends('layouts.master-blue')
@section('title')
Workstation
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
{{-- css for select --}}
{{ HTML::style(asset('css/select.bootstrap.min.css')) }}
<link rel="stylesheet" href="{{ url('css/style.css') }}"  />
<style>
	#page-body{
		display: none;
	}
</style>
@stop
@section('content')
<div class="container-fluid" id="page-body">
@include('modal.workstation.deploy')
@include('modal.workstation.transfer')
	<div class="col-md-12" id="workstation-info">
		<div class="panel panel-body  table-responsive">
				<table class="table table-hover table-striped table-bordered" id="workstationTable">
					<thead>
						<th>ID</th>
						<th>OS</th>
						<th>System Unit</th>
						<th>Monitor</th>
						<th>AVR</th>
						<th>Keyboard</th>
						<th>Mouse</th>
						<th>Location</th>
					</thead>
				</table>
		</div>
		<input type="hidden" val="" name="selected" id="selected" />
	</div>
</div>
@stop
@section('script')
{{-- javascript for select --}}
{{ HTML::script(asset('js/dataTables.select.min.js')) }}
<script type="text/javascript">

	$(document).ready(function() {

		@if( Session::has("success-message") )
		  swal("Success!","{{ Session::pull('success-message') }}","success");
		@endif
		@if( Session::has("error-message") )
		  swal("Oops...","{{ Session::pull('error-message') }}","error");
		@endif

    	var table = $('#workstationTable').DataTable( {
			"pageLength": 100,
	  		select: {
	  			style: 'multiple'
	  		},
		    language: {
		        searchPlaceholder: "Search..."
		    },
	    	"dom": "<'row'<'col-sm-9'<'toolbar'>><'col-sm-3'f>>" +
						    "<'row'<'col-sm-12'tr>>" +
						    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
			"processing": true,
	        ajax: "{{ url('workstation') }}",
	        columns: [
	        	{ data: 'id' },
	            { data: function(callback){
	            	var ret_val;
	            	try{
	            		ret_val = callback.oskey;
	            		if (ret_val == "" || ret_val == null) ret_val = 'None';
	            	} catch ( error){ 
	            		ret_val = 'None';
	            	}
	            	return ret_val;
	            }},
	            { data: function(callback)
	            {
	            	var ret_val;
	            	try{
	            		ret_val = callback.systemunit.propertynumber;
	            	} catch (error) {
	            		ret_val = 'None';
	            	} 
            		return ret_val;
	            } },
	            { data: function(callback)
	            {
	            	var ret_val;
	            	try{
	            		ret_val = callback.monitor.propertynumber;
	            	} catch (error) {
	            		ret_val = 'None';
	            	} 
            		return ret_val;
	            } },
	            { data: function(callback)
	            {
	            	var ret_val;
	            	try{
	            		ret_val = callback.avr.propertynumber;
	            	} catch (error) {
	            		ret_val = 'None';
	            	} 
            		return ret_val;
	            } },
	            { data: function(callback)
	            {
	            	var ret_val;
	            	try{
	            		ret_val = callback.keyboard.propertynumber;
	            	} catch (error) {
	            		ret_val = 'None';
	            	} 
            		return ret_val;
	            } },
	            { data: function(callback){
	            	if(callback.mouse == 1) {
	            		return 'Included';
	            	} else{
	            		return 'None';
	            	}
	            } },
	            { data: function(callback)
	            {
	            	var ret_val;
	            	try{
	            		ret_val = callback.systemunit.roominventory.room.name;
	            	} catch (error) {
	            		ret_val = 'None';
	            	} 
            		return ret_val;
	            } },
	        ],
	    } );

	 	$("div.toolbar").html(`

	 			<a id="new" class="btn btn-primary btn-flat" style="margin-right:5px;padding: 5px 10px;" href="{{ url('workstation/create') }}">
	 				<span class="glyphicon glyphicon-plus"></span>  Create
	 			</a>
	 			<button id="edit" class="btn btn-default btn-flat" style="margin-right:5px;padding: 5px 10px;">
	 				<span class="glyphicon glyphicon-pencil"></span>  Edit
	 			</button>
	 			<button id="deploy" class="btn btn-info btn-flat" style="margin-right:5px;padding: 5px 10px;">
	 				<span class="glyphicon glyphicon-share-alt"></span>  Deploy
	 			</button>
	 			<button id="transfer" class="btn btn-warning btn-flat" style="margin-right:5px;padding: 5px 10px;">
	 				<span class="glyphicon glyphicon-share"></span>  Transfer
	 			</button>
	 			<button id="delete" class="btn btn-danger btn-flat" data-loading-text="Loading..." style="margin-right:5px;padding: 5px 10px;">
	 				<span class="glyphicon glyphicon-trash"></span> Disassemble
	 			</button>
		`);

		$('#deploy').on('click',function(){
			try{
				if(table.row('.selected').data().id != null && table.row('.selected').data().id  && table.row('.selected').data().id >= 0)
				{
					var array = [];
					table.rows('.selected').every(function(row) {
						array.push(table.row(row).data().id);
					})   

					$('#selected').val(array);
					$('#deployWorkstationModal').modal('show');
				}
			}catch( error ){
				swal('Oops..','You must choose atleast 1 row','error');
			}
		})

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

		$('#transfer').on('click',function(){
			try{
				if(table.row('.selected').data().id != null && table.row('.selected').data().id  && table.row('.selected').data().id >= 0)
				{
					var array = [];
					table.rows('.selected').every(function(row) {
						array.push(table.row(row).data().id);
					})   

					$('#selected').val(array);
					$('#transferWorkstationModal').modal('show');
				}
			}catch( error ){
				swal('Oops..','You must choose atleast 1 row','error');
			}
		})

		$('#modal-deploy').on('click',function(){
			try{
				if(table.row('.selected').data().id != null && table.row('.selected').data().id  && table.row('.selected').data().id >= 0)
				{
		   			var $btn = $(this).button('loading')
					$.ajax({
						type: 'post',
						url: '{{ route("workstation.deploy") }}',
						data: {
							'room' : $('#room').val(),
							'items': $('#items').val()
						},
						dataType: 'json',
						success: function(response){
							if(response == 'success'){
								swal('Success','Workstation/s successfully deployed','success');
							} else if(response == 'error'){
								swal('Oops','Something went wrong while deploying workstation/s','error');
							}

							table.ajax.reload();
		    				$btn.button('reset')
						},
						error: function(response){
		   				 	$btn.button('reset')
							swal('Error Occurred','Something went wrong while sending your request. Please reload the page','error')
						}
					});
				}
			}catch( error ){
				swal('Oops..','You must choose atleast 1 row','error');
			}
		});

		$('#modal-transfer').on('click',function(){
			try{
				if(table.row('.selected').data().id != null && table.row('.selected').data().id  && table.row('.selected').data().id >= 0)
				{
		   			var $btn = $(this).button('loading')
					$.ajax({
						type: 'post',
						url: '{{ route("workstation.transfer") }}',
						data: {
							'room' : $('#transfer-room').val(),
							'items': $('#transfer-items').val()
						},
						dataType: 'json',
						success: function(response){
							if(response == 'success'){
								swal('Success','Workstation/s transferred','success');
							} else if(response == 'error'){
								swal('Oops','Something went wrong while changing the location of a workstation','error');
							}

							table.ajax.reload();
		    				$btn.button('reset')
						},
						error: function(response){
		   				 	$btn.button('reset')
							swal('Error Occurred','Something went wrong while sending your request. Please reload the page','error')
						}
					});
				}
			}catch( error ){
				swal('Oops..','You must choose atleast 1 row','error');
			}
		});


		$('#edit').on('click',function(){
			try{
				if(table.row('.selected').data().id != null && table.row('.selected').data().id  && table.row('.selected').data().id >= 0)
				{
					window.location.href = "{{ url('workstation') }}" + '/' + table.row('.selected').data().id + '/edit';
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
			          text: "This workstation will only be disassembled. Each equipments record will not be deleted. Do you want to continue?",
			          type: "warning",
			          showCancelButton: true,
			          confirmButtonText: "Yes, delete it!",
			          cancelButtonText: "No, cancel it!",
			          closeOnConfirm: false,
			          closeOnCancel: false
			        },
			        function(isConfirm){
			          if (isConfirm) {
   						var $btn = $(this).button('loading')
     					$.ajax({
							type: 'delete',
							url: '{{ url("workstation/") }}' + "/" + table.row('.selected').data().id,
							data: {
								'selected': $('#selected').val()
							},
							dataType: 'json',
							success: function(response){
								if(response == 'success'){
									swal('Operation Successful','Workstation disassembled','success')
					        		table.row('.selected').remove().draw( false );
					        	}else{
									swal('Operation Unsuccessful','Error occurred while processing your request','error')
								}

								table.ajax.reload();
    							$btn.button('reset')
							},
							error: function(){
								swal('Operation Unsuccessful','Error occurred while processing your request','error')
    							$btn.button('reset')
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
