@extends('layouts.master-blue')
@section('title')
Reservation
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
	{{ HTML::style(asset('css/_materialFullCalendar.scss')) }}
	{{ HTML::style(asset('css/fullcalendar.min.css')) }}
	{{ HTML::style(asset('css/fullcalendar.print.min.css',['media'=>'print'])) }}
	{{ HTML::style(asset('css/jquery.timepicker.min.css')) }}
	<style>
		#calendar-panel, #hide,#hide-notes,#reservation-info{
			display:none;
		}
		.panel-padding{
			padding: 10px;
		}
	</style>
@stop
@section('script-include')
	{{ HTML::script(asset('js/moment.min.js')) }}
	{{ HTML::script(asset('js/fullcalendar.min.js')) }}
	{{ HTML::script(asset('js/gcal.min.js')) }}
	{{ HTML::script(asset('js/jquery.timepicker.min.js')) }}
@stop
@section('content')
<div class="container-fluid" id="page-body" hidden>
	<div class="col-md-6"  id='calendar-panel'>
		<div id="calendar" class="panel panel-body"></div>
	</div>
	<div class="col-md-offset-3 col-md-6 panel panel-body" id="reservation" style="padding: 10px;">
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
		<div style="padding:20px;">
			<legend>
				<h3 style="color:#337ab7;">Reservation Form
				{{ Form::button('Show Notes',[
					'class'=>'pull-right btn btn-link btn-primary',
					'id' => 'show-notes'
				]) }}
				{{ Form::button('Hide Notes',[
					'class'=>'pull-right btn btn-link btn-primary',
					'id' => 'hide-notes'
				]) }}
				{{ Form::button('Show Calendar',[
					'class'=>'pull-right btn btn-link btn-primary',
					'id' => 'show'
				]) }}
				{{ Form::button('Hide Calendar',[
					'class'=>'pull-right btn btn-link btn-primary',
					'id' => 'hide'
				]) }}
				</h3>
			</legend>
			{{ Form::open(['class'=>'form-horizontal','method'=>'post','route'=>'reservation.store','id'=>'reservationForm']) }}
			<!-- date of use -->
			<div class="form-group">
				<div class="col-sm-3">
				{{ Form::label('dateofuse','Date of Use') }}
				</div>
				<div class="col-sm-9">
				{{ Form::text('dateofuse',Input::old('dateofuse'),[
					'class'=>'form-control',
					'placeholder'=>'MM | DD | YYYY',
					'readonly',
					'style'=>'background-color: #ffffff	'
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
					'id' => 'starttime',
					'readonly',
					'style'=>'background-color: #ffffff	'
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
					'class'=>'form-control background-white',
					'placeholder'=>'Hour : Min',
					'id' => 'endtime',
					'readonly',
					'style'=>'background-color: #ffffff	'
				]) }}
				</div>
			</div>
			<!-- Item type -->
			<div class="form-group">
				<div class="col-sm-3">
				{{ Form::label('itemtype','Item type') }}
				</div>
				<div class="col-sm-9">
				{{ Form::select('type',['Loading all item types...'],Input::old('item'),[
					'id'=>'type',
					'class'=>'form-control'
				]) }}
				</div>
			</div>
			<!-- Item name -->
			<div class="form-group">
				<div class="col-sm-3">
				{{ Form::label('itemname','Item name') }}
				</div>
				<div class="col-sm-9">
				{{ Form::select('itemname',['Loading all item names'],Input::old('itemname'),[
					'id'=>'itemname',
					'class'=>'form-control'
				]) }}
				</div>
			</div>
			<!-- Item name -->
			<div class="form-group">
				<div class="col-sm-3">
				{{ Form::label('property_number','Property Number') }}
				</div>
				<div class="col-sm-9">
				{{ Form::select('property_number',['Loading all Property Number'],Input::old('property_number'),[
					'id'=>'property_number',
					'class' => 'form-control'
				]) }}
				</div>
			</div>
			<!-- Purpose -->
			<div class="form-group">
				<div class="col-sm-3">
				{{ Form::label('purpose','Purpose') }}
				</div>
				<div class="col-sm-9">
				{{ Form::select('purpose',['Loading all purpose...'],Input::old('purpose'),[
					'class'=>'form-control'
				]) }}
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
				{{ Form::label('location','Location') }}
				</div>
				<div class="col-sm-9">
				{{ Form::select('location',['Loading all locations'],Input::old('location'),[
					'class'=>'form-control'
				]) }}
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-12">
				{{ Form::button('Request',[
					'class'=>'btn btn-primary btn-block',
					'id'=>'request'
				]) }}
				</div>
			</div>
			{{ Form::close() }}
		</div>
	</div>
	@include('reservation.notes')
</div>
@stop
@include('reservation.create-reservation-script')
