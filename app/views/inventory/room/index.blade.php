@extends('layouts.master-blue')
@section('title')
Room Inventory
@stop
@section('navbar')
@include('layouts.navbar')
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
	<div class="" style="background-color: white;padding: 20px;">
		<table class="table table-hover table-condensed table-bordered table-responsive" id="roomTable">
			<thead>
				<th>Item Model</th>
				<th>Item Brand</th>
				<th>Property Number</th>
				<th>Date Assigned</th>
			</thead>
		</table>
	</div>
</div>
@stop
@section('script')
{{ HTML::script(asset('js/dataTables.select.min.js')) }}
{{ HTML::script(asset('js/moment.min.js')) }}
<script type="text/javascript">
	$(document).ready(function() {

		init(1);

		function init(data)
		{

			table = $('#roomTable').DataTable({
					"processing": true,
			        ajax: "{{ url('get/room/inventory') }}" + '/' + data,
			  		select: {
			  			style: 'single'
			  		},
				    language: {
				        searchPlaceholder: "Search..."
				    },
			    	"dom": "<'row'<'col-sm-9'<'toolbar'>><'col-sm-3'f>>" +
								    "<'row'<'col-sm-12'tr>>" +
								    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
			        columns: [
			            { data: "model" },
			            { data: "brand" },
			            { data: "propertynumber" },
			            { data: function(){
								if(moment("created_at").isValid()){
									return moment('created_at','MMM-DD-YYYY');
								}else{
									return moment().format('MMM DD, YYYY');
								}
							}
						},
			        ],
			    } );

			 	$("div.toolbar").html(`
					<div class="btn-group">
					  <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="room" style="padding:10px;"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Room <span class="caret"></span>
					  </button>
					  <ul class="dropdown-menu" id="room-items">
					      @foreach($rooms as $room)
							<li role="presentation">
								<a class="room" data-id='{{ $room->id }}'>{{ $room->name }}</a>
							</li>
					    @endforeach
					  </ul>
					</div>
				  	<a class="btn btn-primary btn-flat" href="{{ url('inventory/room/assign') }}" id="assign" style="padding:10px;"><span class="glyphicon glyphicon-check" aria-hidden="true"></span> Assign</a>
				`);

		}
		$('.room').on('click',function(event)
		{
			table.ajax.url("{{ url('get/room/inventory') }}" + '/' + $(this).data('id')).load();
		})

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
