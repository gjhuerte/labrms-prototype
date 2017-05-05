@extends('layouts.master-blue')
@section('title')
Item Types
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('content')
<div class="container-fluid">
	<div class="col-sm-offset-2 col-sm-4  panel panel-body">
		<div class="col-sm-8 text-primary">
			<strong>Add New Item Type</strong>. 
		</div>
		<div class="col-sm-4">
			{{ Form::open(['url'=>'item/type/create','method'=>'get']) }}
			{{ Form::submit('Add',[
				'class' => 'btn btn-primary btn-block'
			]) }}
			{{ Form::close() }}
		</div>
	</div>
	<div class="col-sm-offset-2 col-sm-8  panel panel-body table-responsive">
		<table class="table table-condensed table-striped table-hover" id='itemTypeTable'>
			<thead>
				<th>Item type</th>
				<th>Description</th>
				<th>Action</th>
			</thead>
			<tbody>
			@if( empty($itemtype) )
			@else
				@foreach( $itemtype as $itemtype )
				<tr>
					<td> {{ $itemtype->type }} </td>
					<td> {{ $itemtype->description }} </td>
					<td>
						{{ Form::open(['method'=>'get','route' => array('item.type.edit',$itemtype->type)]) }}
						<button class="btn col-sm-4 btn-sm btn-primary" name="update" type="submit" value="Update"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
						{{ Form::close() }}
						{{ Form::open(['method'=>'delete','route' => array('item.profile.destroy',$itemtype->type),'id'=>'deletionForm']) }}	
						<button class="btn col-sm-4 btn-sm btn-danger delete" name="delete" type="submit" value="Condemn"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
						{{ Form::close() }}
					</td>
				</tr>
				@endforeach
			@endif
			</tbody>
		</table>
	</div>
</div>
@stop
@section('script')
<script type="text/javascript">
	$(document).ready(function(){
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
