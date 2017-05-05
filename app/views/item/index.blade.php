@extends('layouts.master-blue')
@section('title')
Inventory
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('content')
<div class="container-fluid">
	<div class="col-md-4 panel panel-body">
		<div class="col-md-8 text-primary">
			<strong>Create an item profile</strong>. 
		</div>
		<div class="col-md-4">
			{{ Form::open(['url'=>'item/profile/create','method'=>'get']) }}
			{{ Form::submit('Create',[
				'class' => 'btn btn-primary btn-block'
			]) }}
			{{ Form::close() }}
		</div>
	</div>
	<div class="row"></div>
	<div class="panel panel-body table-responsive">
		<table class="table table-hover">
			<thead>
				<th>Item name</th>
				<th>Total Quantity Bought</th>
				<th>Added</th>
				<th>Operational</th>
				<th>For Condemn</th>
				<th>Total</th>
				<th>Action</th>
			</thead>
			<tbody>
			@if( empty($inventorydetails) )
				<tr>
					<td> --- </td>
					<td> --- </td>
					<td> --- </td>
					<td> --- </td>
					<td> --- </td>
					<td> --- </td>
				</tr>
			@else
				@foreach( $inventorydetails as $inventory )
				<tr>
					<td> {{ $inventory->itemname }} </td>
					<td> {{ $inventory->quantity }} </td>
					<td> {{ $inventory->added }} </td>
					<td> {{ $inventory->adjust }} </td>
					<td> {{ $inventory->deduct }} </td>
					<td> {{ $inventory->total }} </td>
					<td>
						<div class="pull-left">
						{{ Form::open(['method'=>'get','route' => array('item.profile.show',$inventory->id)]) }}	
						{{ Form::submit('View',[
							'class'=>'btn btn-info',
							'name'=>'view'
						]) }}
						{{ Form::close() }}
						</div>
						<div class="pull-left">
						{{ Form::open(['method'=>'put','route' => array('item.profile.update',$inventory->id)]) }}
						{{ Form::submit('Update',[
							'class'=>'btn btn-primary',
							'name' => 'update'
						]) }}
						{{ Form::close() }}
						</div>
						<div class="pull-right">
						{{ Form::open(['method'=>'delete','route' => array('item.profile.destroy',$inventory->id),'id'=>'deletionForm']) }}	
						{{ Form::submit('Condemn',[
							'class' => 'btn btn-warning delete',
							'name' => 'delete'
						]) }}
						{{ Form::close() }}
						</div>
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
	@if( Session::has("success-message") )
	  swal("Success!","{{ Session::pull('success-message') }}","success");
	@endif
	@if( Session::has("error-message") )
	  swal("Oops...","{{ Session::pull('error-message') }}","error");
	@endif

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
</script>
@stop
