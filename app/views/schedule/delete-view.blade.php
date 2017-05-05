@extends('layouts.master-blue')
@section('title')
Schedule
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
<style>
	#page-body{
		display: none;
	}
</style>
@stop
@section('content')
<div class="container-fluid" id="page-body">
	@include('schedule.sidebar.default')
	<div class="col-md-10" style="background: white;">
		<div class="panel panel-body table-responsive">
			<table class="table table-hover table-striped" id='scheduleTable'>
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
							{{ Form::open(['method'=>'delete','route'=>array('schedule.destroy',$schedule->id),'id'=>'deletionForm']) }}
							{{ Form::button('Delete',[
								'class' => 'btn btn-sm btn-danger delete'
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
</div>
@stop
@section('script')
<script type="text/javascript">
	$(document).ready(function(){
		$('#page-body').show();
		$('#scheduleTable').dataTable();
		@if( Session::has("success-message") )
			swal("Success!","{{ Session::pull('success-message') }}","success");
		@endif
		@if( Session::has("error-message") )
			swal("Oops...","{{ Session::pull('error-message') }}","error");
		@endif
	});
</script>
@stop