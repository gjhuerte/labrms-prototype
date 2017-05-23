@extends('layouts.master-blue')
@section('title')
Room Inventory
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
<style>
	#page-body{
		display: none;
	}
</style>
@stop
@section('content')
<div class="container-fluid" id="page-body">
	@include('inventory.room.sidebar.default')
	<div class="col-md-12">
		<div style="margin-bottom: 10px;">
			<button class="btn btn-default" id="simple-menu" href="#sidr"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> <span id="nav-text">Rooms</span></button>
		  <button class="btn btn-default" id="assign"><span class="glyphicon glyphicon-check" aria-hidden="true"></span> Assign</button>
		</div>
		<div class="panel panel-body panel-shadow table-responsive">
			<table class="table table-hover table-condensed table-bordered" id="roomTable">
				<thead>
					<th>Item Model</th>
					<th>Item Brand</th>
					<th>Property Number</th>
					<th>Date Assigned</th>
				</thead>
			</table>
		</div>
	</div>
</div>
@stop
@section('script')
<script type="text/javascript">
	$(document).ready(function() {

		$('#assign').click(function(){
				window.location.href = "{{ url('inventory/room/assign') }}";
		});

		initDataTable('1');

		$('.room').on('click',function(event)
		{
			initDataTable($(this).data('id'));
		})

		@if( Session::has("success-message") )
			swal("Success!","{{ Session::pull('success-message') }}","success");
		@endif
		@if( Session::has("error-message") )
			swal("Oops...","{{ Session::pull('error-message') }}","error");
		@endif

		function initDataTable(data)
		{
			if ($.fn.DataTable.isDataTable("#roomTable")) {
		  	$('#roomTable').DataTable().clear().destroy();
			}

			$('#roomTable').DataTable({
					"processing": true,
	        ajax: "{{ url('get/room/inventory') }}" + '/' + data,
	        columns: [
	            { data: "model" },
	            { data: "brand" },
	            { data: "propertynumber" },
	            {
								data: function(){
									if(moment("created_at").isValid()){
										return moment('created_at','MMM-DD-YYYY');
									}else{
										return moment().format('MMM DD, YYYY');
									}
								}
							},
	        ],
	    } );
		}

		$('#page-body').show();
	} );
</script>
@stop
