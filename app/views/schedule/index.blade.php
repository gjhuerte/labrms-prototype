@extends('layouts.master-blue')
@section('title')
Schedule
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('content')
<div class="container-fluid">
	<div class="col-md-offset-1 col-md-4 panel panel-body">
		<div class="col-md-8 text-primary">
			<strong>Create a schedule now to track room usage and availability </strong>. 
		</div>
		<div class="col-md-4">
			{{ Form::open(['method'=>'get','route'=>'schedule.create']) }}
			{{ Form::submit('Create',[
				'class' => 'btn btn-primary btn-block'
			]) }}
			{{ Form::close() }}
		</div>
	</div>	<div class="col-md-offset-1 col-md-10" style="background: white;">
		<div class="panel panel-body table-responsive">
			<table class="table table-hover table-striped table-condensed" id='scheduleTable'>
				<thead>
					<th>Day</th>	
					<th>Time In</th>
					<th>Time Out</th>
					<th>Room Name</th>
					<th>Faculty-in-charge</th>
					<th>Subject</th>
					<th>Course, Year & Section</th>
					<th>Action</th>
				</thead>
				<tbody>
					@if(count($schedules) == 0)
					@else
					@foreach($schedules as $schedule)
					<tr>
						<td>{{ $schedule->day }}</td>
						<td>{{ $schedule->timein }}</td>
						<td>{{ $schedule->timeout }}</td>
						<td>{{ $schedule->room->name }}</td>
						<td>{{ $schedule->facultyincharge }}</td>
						<td>{{ $schedule->courseyearsection }}</td>
						<td>{{ $schedule->subject }}</td>
						<td>
							<div class="pull-left">
							{{ Form::open(['method'=>'get','route'=>array('schedule.show',$schedule->id)]) }}
							{{ Form::submit('Show',[
								'class' => 'btn btn-sm btn-primary col-sm-4 btn-block'
							]) }}
							{{ Form::close() }}
							</div>
							<div class="pull-left">
							{{ Form::open(['method'=>'get','route'=>array('schedule.edit',$schedule->id)]) }}
							{{ Form::submit('Update',[
								'class' => 'btn btn-sm btn-info col-sm-4 btn-block'
							]) }}
							{{ Form::close() }}
							</div>
							<div class="pull-right">
							{{ Form::open(['method'=>'delete','route'=>array('schedule.destroy',$schedule->id),'id'=>'deletionForm']) }}
							{{ Form::button('Delete',[
								'class' => 'btn btn-sm btn-danger col-sm-4 btn-block delete'
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
</div>
@stop
@section('script')
<script type="text/javascript">
	$('#scheduleTable').dataTable();
	@if( Session::has("success-message") )
	  swal("Success!","{{ Session::pull('success-message') }}","success");
	@endif
	@if( Session::has("error-message") )
	  swal("Oops...","{{ Session::pull('error-message') }}","error");
	@endif
  $('.delete').click(function(){
    swal({
      title: "Are you sure?",
      text: "This process is irrreversible, do you want to continue?",
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