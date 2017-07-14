@extends('layouts.master-blue')
@section('title')
Holiday | Update
@stop
@section('navbar')
@include('layouts.navbar.admin.default')
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
	 		{{ Form::open(['method'=>'put','route'=>array('holiday.update',$holiday->id),'class'=>'form-horizontal','id'=>'inventoryForm']) }}
			<ul class="breadcrumb">
				<li><a href="{{ url('holiday') }}">Holiday</a></li>
				<li>{{ $holiday->id }}</li>
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

		$('#title').val('{{ $holiday->title }}')


		$("#date").val('{{ Carbon\Carbon::parse($holiday->date)->toFormattedDateString() }}');

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
