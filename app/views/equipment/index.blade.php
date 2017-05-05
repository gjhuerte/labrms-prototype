@extends('layouts.master-blue')
@section('title')
Equipments
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('content')
<div class="container-fluid">
	<div class="col-sm-4 panel panel-body">
		<div class="col-md-8 text-primary">
			<strong>Create an equipment profile</strong>. 
		</div>
		<div class="col-md-4">
			{{ Form::open(['method'=>'get','route'=>'equipment.create']) }}
			{{ Form::submit('Create',[
				'class' => 'btn btn-primary btn-block'
			]) }}
			{{ Form::close() }}
		</div>
	</div>
	<div class="col-sm-12 panel panel-body table-responsive">
		<table class="table table-hover table-striped table-condensed" id="itemProfileTable">
			<thead>
				<th>Property Number</th>
				<th>Serial ID</th>
				<th>MR Number</th>
				<th>Item Name</th>
				<th>Type</th>
				<th>Status</th>
				<th>Location</th>
				<th>  </th>
			</thead>
			<tbody>
			@if( empty($items) )
				<tr>
					<td> --- </td>
					<td> --- </td>
					<td> --- </td>
					<td> --- </td>
					<td> --- </td>
					<td> --- </td>
					<td> --- </td>
				</tr>
			@else
				@foreach( $items as $item )
				<tr>
					<td> {{ $item->property_number }} </td>
					<td> {{ $item->serialid }} </td>
					<td> {{ $item->MR_no }} </td>
					<td> {{ $item->inventory->itemname }} </td>
					<td> {{ $item->type }} </td>
					<td> {{ $item->status }} </td>
					<td> {{ $item->location }} </td>
					<td>
						{{ Form::open(['method'=>'get','route' => array('equipment.show',$item->id)]) }}	
						{{ Form::submit('View',[
							'class'=>'col-sm-4 btn-block btn btn-sm btn-info',
							'name'=>'view'
						]) }}
						{{ Form::close() }}
						{{ Form::open(['method'=>'get','route' => array('equipment.edit',$item->id)]) }}
						{{ Form::submit('Update',[
							'class'=>'col-sm-4 btn-block btn btn-sm btn-primary',
							'name' => 'update'
						]) }}
						{{ Form::close() }}
						{{ Form::open(['method'=>'delete','route' => array('equipment.destroy',$item->id),'id'=>'deletionForm']) }}	
						{{ Form::submit('Condemn',[
							'class' => 'col-sm-4 btn-block btn btn-sm btn-warning delete',
							'name' => 'delete'
						]) }}
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
	$('#itemProfileTable').dataTable();
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
