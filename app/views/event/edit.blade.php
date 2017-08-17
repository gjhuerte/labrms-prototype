@extends('layouts.master-blue')
@section('title')
Event | Update
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
{{ HTML::style(asset('css/datepicker.min.css')) }}
{{ HTML::style(asset('css/style.css')) }}
<style>
	#page-body{
		display:none;
	}
</style>
@stop
@section('content')
<div class="container-fluid" id="page-body">
	<div class='col-md-offset-3 col-md-6'>
		<div class="panel panel-body" style="padding-top: 20px;padding-left: 40px;padding-right: 40px;">
	      @if (count($errors) > 0)
         	 <div class="alert alert-danger alert-dismissible" role="alert">
	          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	              <ul class="list-unstyled" style='margin-left: 10px;'>
	                  @foreach ($errors->all() as $error)
	                      <li class="text-capitalize">{{ $error }}</li>
	                  @endforeach
	              </ul>
	          </div>
	      @endif
	 		{{ Form::open(['method'=>'put','route'=>array('event.update',$event->id),'class'=>'form-horizontal','id'=>'inventoryForm']) }}
			<ul class="breadcrumb">
				<li><a href="{{ url('event') }}">Event</a></li>
				<li>{{ $event->id }}</li>
				<li class="active">edit</li>
			</ul>
			<div class="form-group">
				<div class="col-sm-12">
				{{ Form::label('title','Title / Name') }}
				{{ Form::text('title',Input::old('title'),[
					'class' => 'form-control',
					'placeholder' => 'Holiday title / name'
				]) }}
				</div>
			</div>
			<!-- date of use -->
			<div class="form-group">
				<div class="col-sm-12">
				{{ Form::label('date','Date Occured',[
    				'data-language'=>"en"
    			]) }}
				{{ Form::text('date',Input::old('date'),[
					'id' => 'date',
					'class'=>'form-control',
					'placeholder'=>'Month | Day | Year',
					'readonly',
					'style'=>'background-color: #ffffff	'
				]) }}
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-12">
		            {{ Form::label('Repeating?') }}
		            <div class="material-switch pull-right">
		                <input id="multiple" name="multiple" type="checkbox"/>
		                <label for="multiple" class="label-success"></label>
		                <span id="multiple-label">No</span>
		            </div>
				</div>
			</div>
			<!-- date of use -->
			<div class="form-group" id="date-occuring" hidden>
				<div class="col-sm-12">
				{{ Form::label('date','Date Occuring',[
    				'data-language'=>"en"
    			]) }}
				<select class="form-control" name="repeatingFormat">
					<option value="weekly">Weekly</option>
					<option value="monthly">Monthly</option>
					<option value="yearly">Year</option>
				</select>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-12">
					<button type="submit" value="create" name="action" id="submit" class="btn btn-lg btn-primary btn-block btn-flat btn-block"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Update </button>
				</div>
			</div>
			{{ Form::close() }}
		</div>
	</div>
</div>
@stop
@section('script')
{{ HTML::script(asset('js/datepicker.min.js')) }}
{{ HTML::script(asset('js/datepicker.en.js')) }}
{{ HTML::script(asset('js/moment.min.js')) }}
<script type="text/javascript">
	$(document).ready(function(){

		$("#date").datepicker({
			language: 'en',
			showOtherYears: false,
			todayButton: true,
			autoClose: true,
			onSelect: function(){
				$('#date').val(moment($('#date').val(),'MM/DD/YYYY').format('MMMM DD, YYYY'))
			}
		});

		$('#multiple').on('change',function(){
			if( $('#date-occuring').is(':visible') ) 
			{	
				$('#multiple-label').text('No')
				$('#date-occuring').hide(400)
			} else {
				$('#multiple-label').text('Yes')
				$('#date-occuring').show(400)
			}
		});

		$('#title').val('{{ $event->title }}')
		@if($event->repeating)
			$('#multiple').prop('checked','checked')
			if( $('#date-occuring').is(':visible') ) 
			{	
				$('#multiple-label').text('No')
				$('#date-occuring').hide(400)
			} else {
				$('#multiple-label').text('Yes')
				$('#date-occuring').show(400)
			}
		@endif


		$("#date").val('{{ Carbon\Carbon::parse($event->date)->toFormattedDateString() }}');

		@if( Session::has("success-message") )
			swal("Success!","{{ Session::pull('success-message') }}","success");
		@endif

		@if( Session::has("error-message") )
			swal("Oops...","{{ Session::pull('error-message') }}","error");
		@endif

		$('#page-body').show();
	})
</script>
@stop
