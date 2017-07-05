@extends('layouts.master-blue')
@section('title')
Room Log
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
{{ HTML::style(asset('css/jquery.timepicker.min.css')) }}
@stop
@section('script-include')
{{ HTML::script(asset('js/jquery.timepicker.min.js')) }}
@stop
@section('content')
<style>
	.panel-padding{
		padding: 10px;
	}
</style>
<div class="container-fluid">
	<div class="col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6">
		@if (count($errors) > 0)
		  <div class="alert alert-danger alert-dismissible" role="alert">
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		      <ul style='margin-left: 10px;'>
		          @foreach ($errors->all() as $error)
		              <li>{{ $error }}</li>
		          @endforeach
		      </ul>
		  </div>
		@endif    
		<div class="panel panel-body" style="padding:20px;">
			<legend><h3 style="color:#337ab7;">Room Log Form</h3></legend>
			{{ Form::open(['class'=>'form-horizontal','method'=>'post','route'=>'room.log.store']) }}
			<!-- Item name -->
			<div class="form-group">
				<div class="col-sm-3">
				{{ Form::label('room','Room Name') }}
				</div>
				<div class="col-sm-9">
				<select class="form-control" name="room" id="room">
				@if(count($rooms) == 0)
					<option>Empty list</option>
				@else
					@foreach($rooms as $room)
					<option value="{{ $room->id }}">{{ $room->name }}</option>
					@endforeach
				@endif
				</select>
				</div>
			</div>
			<!-- creator name -->
			<div class="form-group">
				<div class="col-sm-3">
				{{ Form::label('name','Faculty-in-charge') }}
				</div>
				<div class="col-sm-9">
				{{ Form::text('name',Input::old('name'),[
					'class'=>'form-control',
					'placeholder'=>'Faculty-in-charge'
				]) }}
				</div>
			</div>
			<!-- Location -->
			<div class="form-group">
				<div class="col-sm-3">
				{{ Form::label('section','Section') }}
				</div>
				<div class="col-sm-9">
				{{ Form::text('section',Input::old('section'),[
					'class'=>'form-control',
					'placeholder'=>'Section'
				]) }}
				</div>
			</div>
			<!-- Location -->
			<div class="form-group">
				<div class="col-sm-3">
				{{ Form::label('units','No. of Working Units') }}
				</div>
				<div class="col-sm-9">
				{{ Form::number('units',Input::old('units'),[
					'class'=>'form-control',
					'placeholder'=>'No. of Working Units'
				]) }}
				</div>
			</div>
			<!-- time started -->
			<div class="form-group">
				<div class="col-sm-3">
				{{ Form::label('time_start','Time started') }}
				</div>
				<div class="col-sm-9">
				{{ Form::text('time_start',Input::old('time_start'),[
					'class'=>'form-control',
					'placeholder'=>'Hour : Min',
					'readonly',
					'id' => 'starttime'
				]) }}
				</div>
			</div>
			<!-- time_end -->
			<div class="form-group">
				<div class="col-sm-3">
				{{ Form::label('time_end','Time end') }}
				</div>
				<div class="col-sm-9">
				{{ Form::text('time_end',Input::old('time_end'),[
					'class'=>'form-control',
					'placeholder'=>'Hour : Min',
					'readonly',
					'id' => 'endtime'
				]) }}
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-6">
				{{ Form::submit('Create',[
					'class'=>'btn btn-primary btn-block'
				]) }}
				</div>
				<div class="col-sm-6">
				{{ Form::button('Cancel',[
					'class'=>'btn btn-info btn-block',
					'id' => 'cancel'
				]) }}
				</div>
			</div>
			{{ Form::close() }}
		</div>
	</div>
</div>
@stop
@section('script')
<script>
	$('#cancel').click(function(){
		window.location.href = '{{ route("dashboard.index") }}';
	});
	@if( Session::has("success-message") )
	  swal("Success!","{{ Session::pull('success-message') }}","success");
	@endif
	@if( Session::has("error-message") )
	  swal("Oops...","{{ Session::pull('error-message') }}","error");
	@endif

	$('#starttime').timepicker({
		timeFormat: 'h:mm p',
		interval: 30,
		minTime: '7',
		maxTime: '7:00pm',
		defaultTime: '7:00am',
		startTime: '7:00am',
		dynamic: false,
		dropdown: true,
		scrollbar: true
	});  

	$('#endtime').timepicker({
	    timeFormat: 'h:mm p',
	    interval: 30,
	    minTime: '8',
	    maxTime: '9:00pm',
	    defaultTime: '8:00am',
	    startTime: '8:00am',
	    dynamic: false,
	    dropdown: true,
	    scrollbar: true
	});
</script>
@stop