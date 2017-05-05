@extends('layouts.master-blue')
@section('title')
Room
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('content')
<div class="container-fluid">
	<div class="col-md-offset-2 col-md-3 panel panel-body" style="background-color:white; padding: 10px;">
		<div class="col-md-8 text-primary">Additional Laboratory Rooms can be added here!</div>
		<div class="col-md-4">
			{{ Form::open(['method'=> 'get','route' => 'room.create']) }}
			{{ Form::submit('Add',[
				'class' => 'btn btn-primary btn-block'
			]) }}
			{{ Form::close() }}
		</div>
	</div>
	<div class="col-md-offset-2 col-md-8" style="background-color:white;padding: 30px;">
		<table class="table table-condensed table-hover table-striped" id="roomTable">
			<thead>
				<th>Name</th>
				<th>Description</th>
				<th>Action</th>
			</thead>
			<tbody>
			@if(empty($rooms))
			@else
				@foreach($rooms as $room)
				<tr>
					<td>{{ $room->name }}</td>
					<td>{{ $room->description }}</td>
					<td>
						{{ Form::open(['method'=>'get','route' => array('room.edit',$room->id)]) }}
						<button class="btn col-sm-4 btn-sm btn-primary" name="update" type="submit" value="Update"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
						{{ Form::close() }}
						{{ Form::open(['method'=>'delete','route' => array('room.destroy',$room->id),'id'=>'deletionForm']) }}	
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
	@if( Session::has("success-message") )
	  swal("Success!","{{ Session::pull('success-message') }}","success");
	@endif
	@if( Session::has("error-message") )
	  swal("Oops...","{{ Session::pull('error-message') }}","error");
	@endif

	$(document).ready(function() {
	    $('#roomTable').DataTable();
	} );

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