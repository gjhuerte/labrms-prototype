@extends('layouts.master-blue')
@section('title')
Item Profile
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('content')
<div class="container-fluid">
	<div class="col-md-offset-3 col-md-6">
	@if(count($schedule) > 0)
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3>Schedule Information</h3>
			</div>
			<div class="panel-body" style="margin-bottom: 10px;">
				<div class="col-sm-4">
					<label class="text-primary">Schedule</label>
				</div>
				<div class="col-sm-8">
					<p class="form-control">{{ $schedule->subject }}</p>
				</div>
				<div class="col-sm-4">
					<label class="text-primary">Professor in-charge</label>
				</div>
				<div class="col-sm-8">
					<p class="form-control">{{ $schedule->facultyincharge }}</p>
				</div>
				<div class="col-sm-4">
					<label class="text-primary">Semester</label>
				</div>
				<div class="col-sm-8">
					<p class="form-control">{{ $schedule->semester }}</p>
				</div>
				<div class="col-sm-4">
					<label class="text-primary">Course Year & Section</label>
				</div>
				<div class="col-sm-8">
					<p class="form-control">{{ $schedule->courseyearsection }}</p>
				</div>
				<div class="col-sm-4">
					<label class="text-primary">Day</label>
				</div>
				<div class="col-sm-8">
					<p class="form-control">{{ $schedule->day }}</p>
				</div>
				<div class="col-sm-4">
					<label class="text-primary">Time In</label>
				</div>
				<div class="col-sm-8">
					<p class="form-control">{{ $schedule->timein }}</p>
				</div>
				<div class="col-sm-4">
					<label class="text-primary">Time Out</label>
				</div>
				<div class="col-sm-8">
					<p class="form-control">{{ $schedule->timeout }}</p>
				</div>
				<div class="col-md-12">
					<div class="pull-right">
					{{ Form::open(['method'=>'delete','route'=>array('schedule.destroy',$schedule->id)]) }}	
					{{ Form::submit('Delete',[
						'class' => 'btn btn-warning',
						'name' => 'delete'
					]) }}
					{{ Form::close() }}
					</div>
					<div class="pull-right">
					{{ Form::open(['method'=>'get','route'=>array('schedule.edit',$schedule->id)]) }}
					{{ Form::submit('Update',[
						'class'=>'btn btn-primary',
						'name' => 'update'
					]) }}
					{{ Form::close() }}
					</div>
				</div>
			</div>
		</div>
	@endif
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
</script>
@stop
