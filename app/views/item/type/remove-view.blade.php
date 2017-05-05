@extends('layouts.master-blue')
@section('title')
Item Types
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
<style>
	#page-body{
		display:none;
	}
</style>
@stop
@section('content')
<div class="container-fluid" id="page-body">
	@include('item.type.sidebar.default')
	<div class="col-md-10">
		<div class="panel panel-body table-responsive">
			<table class="table table-condensed table-striped table-hover" id='itemTypeTable'>
				<thead>
					<th>Item type</th>
					<th>Description</th>
					<th> </th>
				</thead>
				<tbody>
				@if( empty($itemtype) )
				@else
					@foreach( $itemtype as $itemtype )
					<tr>
						<td> {{ $itemtype->type }} </td>
						<td> {{ $itemtype->description }} </td>
						<td>
							{{ Form::open(['method'=>'delete','route' => array('item.profile.destroy',$itemtype->type),'id'=>'deletionForm']) }}	
							<button class="btn btn-md btn-warning delete" name="delete" type="submit" value="Condemn"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Remove</button>
							{{ Form::close() }}
						</td>
					</tr>
					@endforeach
				@endif
				</tbody>
			</table>
		</div>
	</div>
</div>
@stop
@section('script')
<script type="text/javascript">
	$(document).ready(function(){
		$('#page-body').show();
		@if( Session::has("success-message") )
		  swal("Success!","{{ Session::pull('success-message') }}","success");
		@endif
		@if( Session::has("error-message") )
		  swal("Oops...","{{ Session::pull('error-message') }}","error");
		@endif

		$('#itemTypeTable').DataTable();

		$('.delete').click(function(){
		swal({
			title: "Are you sure?",
			text: "This process is irreversible, do you want to continue?",
			type: "warning",
			showCancelButton: true,
			confirmButtonText: "Yes, i want to continue!",
			cancelButtonText: "No, cancel it!",
			closeOnConfirm: false,
			closeOnCancel: false
		},
		function(isConfirm){
			if (isConfirm) {
					$("#deletionForm").submit();
				} else {
					swal("Cancelled", "Deletion Cancelled", "error");
				}
			});
		});
	});
</script>
@stop
