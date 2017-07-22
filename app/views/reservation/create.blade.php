@extends('layouts.master-blue')
@section('title')
Reservation
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
	<link rel="stylesheet" href="{{ asset('css/selectize.bootstrap3.css') }}" type="text/css">
	{{ HTML::style(asset('css/bootstrap-tagsinput.css')) }}
	{{ HTML::style(asset('css/datepicker.min.css')) }}
	{{ HTML::style(asset('css/monthly.css')) }}
	{{ HTML::style(asset('css/bootstrap-clockpicker.min.css')) }}
	{{ HTML::style(asset('css/style.min.css')) }}
	<style>
		#page-body, #hide,#hide-notes,#reservation-info{
			display:none;
		}
		.panel-padding{
			padding: 10px;
		}
		
	</style>
@stop
@section('script-include')
	{{ HTML::script(asset('js/moment.min.js')) }}
	{{ HTML::script(asset('js/datepicker.min.js')) }}
	{{ HTML::script(asset('js/datepicker.en.js')) }}
	{{ HTML::script(asset('js/monthly.js')) }}
	{{ HTML::script(asset('js/bootstrap-clockpicker.min.js')) }}
@stop
@section('content')
<div class="container-fluid" id="page-body">
	@include('modal.reservation.calendar')
	@include('modal.reservation.item-add')
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
					<div class="btn-group pull-right">
						<div class="btn-group">
						{{ Form::button('Show Notes',[
							'class'=>'btn btn-sm btn-primary',
							'id' => 'show-notes'
						]) }}
						</div>
						<div class="btn-group">
						{{ Form::button('Hide Notes',[
							'class'=>'btn btn-sm btn-primary',
							'id' => 'hide-notes'
						]) }}
						</div>
						<div class="btn-group">
						{{ Form::button('Show Calendar',[
							'class'=>'btn btn-sm btn-default',
							'id' => 'show',
							'data-toggle'=>'modal',
							'data-target' => 'reservationCalendarModal'
						]) }}
						</div>
					</div>
				</h3>
			</legend>
			{{ Form::open(['class'=>'form-horizontal','method'=>'post','route'=>'reservation.store','id'=>'reservationForm']) }}
			@if(Auth::user()->type != 'faculty')
			<!-- creator name -->
			<div class="form-group">
				<div class="col-sm-3">
				{{ Form::label('name','Faculty-in-charge') }}
				</div>
				<div class="col-sm-9">
				{{
					Form::select('name',[],Input::old('name'),[
					'id'=>'name',
					'class'=>'form-control'
				]) }}
				</div>
			</div>
			@endif
			<!-- Location -->
			<div class="form-group">
				<div class="col-sm-3">
				{{ Form::label('location','Location') }}
				</div>
				<div class="col-sm-9">
				{{
					Form::select('location',[],Input::old('location'),[
					'id'=>'location',
					'class'=>'form-control'
				]) }}
				</div>
			</div>
			<!-- date of use -->
			<div class="form-group">
				<div class="col-sm-3">
				{{ Form::label('dateofuse','Date of Use',[
    				'data-language'=>"en"
    			]) }}
				</div>
				<div class="col-sm-9">
				{{ Form::text('dateofuse',Input::old('dateofuse'),[
					'id' => 'dateofuse',
					'class'=>'form-control',
					'placeholder'=>'MM | DD | YYYY',
					'readonly',
					'style'=>'background-color: #ffffff	'
				]) }}
				</div>
			</div>
			<hr />
			<div class="clearfix">
				<p class="text-muted">Note: The system is using military time. 12:00 AM is equivalent to 00:00. </p>
			</div>
			<!-- time started -->
			<div class="form-group" id="time-start-group">
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
				<span id="time-start-error-message" class="text-danger" style="font-size:10px;"></span>
				</div>
			</div>
			<!-- time_end -->
			<div class="form-group" id="time-end-group">
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
				<span id="time-end-error-message" class="text-danger" style="font-size:10px;"></span>
				</div>
			</div>
			<hr />
			<!-- Item type -->
			<div class="form-group">
					<div class="col-xs-3">
						{{ Form::label('itemtype','Items') }}
					</div>
					<div class="col-xs-7"> 
						<div class="input-group">
							  <input type="text" class="form-control" id="items" name="items" role='button' data-role="tagsinput" readonly style="background-color: white;">
						      <span class="input-group-btn">
								<button type="button" class="btn btn-success" data-toggle="modal" data-target="#itemAddModal">Add</button>
						      </span>
						</div>
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
		  <div class="form-group">
		    <div class="col-sm-12">
					<p class="text-muted text-justified">
						By clicking the request button, you agree to CCIS - LOO Terms and Conditions regarding reservation and lending equipments. <span class="text-danger"> The information filled up will no longer be editable and is final.</span>
					</p>
		    </div>
		  </div>
			<div class="form-group">
				<div class="col-sm-12">
				{{ Form::button('Request',[
					'class'=>'btn btn-lg btn-primary btn-block',
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
