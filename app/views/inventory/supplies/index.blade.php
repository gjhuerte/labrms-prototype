@extends('layouts.master-blue')
@section('title')
Inventory | Supplies
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style-include')
{{ HTML::style(asset('css/jquery.sidr.light.min.css')) }}
{{ HTML::style(asset('css/sidr-style.min.css')) }}
@stop
@section('script-include')
{{ HTML::script(asset('js/jquery.sidr.min.js')) }}
{{ HTML::script(asset('js/jquery.hideseek.min.js')) }}
<script src="{{ asset('js/jQuery.succinct.min.js') }}"></script>
@stop
@section('style')
{{ HTML::style(asset('css/select.bootstrap.min.css')) }}
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
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
@section('content')
<div class="container-fluid" id="page-body">
@include('modal.supply.consume')
	<div class="col-md-12">
		<div class="panel panel-body table-responsive">
			<table class="table table-hover table-striped table-bordered table-condensed" id="inventoryTable">
				<thead>
					<th>ID</th>
					<th>Brand</th>
					<th>Type</th>
					<th>Unit</th>
					<th>Quantity</th>
					<th class="col-md-1 no-sort"></th>
				</thead>
			</table>
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

	    var table = $('#inventoryTable').DataTable({
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
	    	columnDefs:[
				{ targets: 'no-sort', orderable: false },
	    	],
			"processing": true,
			ajax: "{{ url('supplies') }}",
			columns: [
					{ data: "id" },
					{ data: "brand" },
					{ data: "itemtype.name" },
					{ data: "unit" },
					{ data: "quantity" },
					{ data: function(callback){
						return `<a class="btn btn-sm btn-default" href="{{ url('supplies/') }}` + '/' +callback.id+`"><span class="glyphicon glyphicon-tasks"></span> Supply History</a>`;
					}}
			],
	    });

	 	$("div.toolbar").html(`
				<button id="add" class="btn btn-flat btn-md btn-primary" data-toggle='modal' data-target='#createSuppliesModal' style="padding: 10px;">
					<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
					<span id="nav-text"> Add</span>
				</button>
				<button id="consume" class="btn btn-default btn-flat" type="button" style="padding: 10px;">
					<span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span>
					<span class="hidden-sm hidden-xs"> Release</span>
				</button>
		`);

	    $('[data-toggle="popover"]').popover();

	    $('#add').on('click',function(){
	    	window.location.href = "{{ url('supplies/create') }}"
	    })

	    $('.truncate').succinct({
	        size: 20
	    });

	    $('#edit').on('click',function(){
			try{
				if(table.row('.selected').data().id != null && table.row('.selected').data().id  && table.row('.selected').data().id >= 0)
				{
					window.location.href = "{{ url('supplies') }}" + "/" + table.row('.selected').data().id + "/edit"
		        }
			}catch( error ){
				swal('Oops..','You must choose atleast 1 row','error');
			}
	    });

	    $('#consume').on('click',function(){
	    	
			try{
		    	if( table.row('.selected').data().quantity > 0 )
		    	{
					try{
						if(table.row('.selected').data().id != null && table.row('.selected').data().id  && table.row('.selected').data().id >= 0)
						{
							$('#consume-id').val(table.row('.selected').data().id)
							$('#consume-quantity').val(table.row('.selected').data().quantity)
							$('#consumeSuppliesModal').modal('show');
				        }
					}catch( error ){
						swal('Oops..','You must choose atleast 1 row','error');
					}	
		    	} else {
		    		swal('Oops...','Supplies has reached zero ( 0 ). No more items to release','error')
		    	}
			}catch( error ){
				swal('Oops..','You must choose atleast 1 row','error');
			}	
	    });

		$('#view').on('click',function(){
			try{
				if(table.row('.selected').data().id != null && table.row('.selected').data().id  && table.row('.selected').data().id >= 0)
				{
					window.location.href = "{{ url('item/profile') }}" + '/' + table.row('.selected').data().id
				}
			}catch( error ){
				swal('Oops..','You must choose atleast 1 row','error');
			}
		})

	    $('#profile').on('click',function(){
				try{
					if(table.row('.selected').data().id != null && table.row('.selected').data().id  && table.row('.selected').data().id >= 0)
					{
			    	window.location.href = "{{ url('item/profile/create?id=') }}" + table.row('.selected').data().id
					}
				}catch( error ){
					swal('Oops..','You must choose atleast 1 row','error');
				}
	    })

		$('#page-body').show();
	} );
</script>
@stop
