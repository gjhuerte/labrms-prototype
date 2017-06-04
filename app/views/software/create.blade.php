@extends('layouts.master-blue')
@section('title')
Create
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
<link rel="stylesheet" href="{{ asset('css/style.min.css') }}" />
<style>
	#page-body,#page-two,#page-three{
		display:none;
	}

	textarea{
		resize:none;
		overflow-y:hidden;
	}
</style>
@stop
@section('content')
<div class="container-fluid" id="page-body">
	<div class='col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6'>
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
		<div class="panel panel-body ">
			<ol class="breadcrumb">
			  <li><a href="{{ url('software') }}">Software</a></li>
			  <li class="active">Create</li>
			</ol>
			{{ Form::open(['method'=>'post','route'=>'software.store','class'=>'form-horizontal']) }}
			<div id="page-one">
				<!-- Title -->
				<div class="form-group">
					<div class="col-sm-12">
					{{ Form::label('name','Software Name') }}
					{{ Form::text('name',Input::old('name'),[
						'class'=>'form-control',
						'placeholder'=>'Software Name'
					]) }}
					</div>
				</div>
				<!-- Company -->
				<div class="form-group">
					<div class="col-sm-12">
					{{ Form::label('company','Company') }}
					{{ Form::text('company',Input::old('company'),[
						'class'=>'form-control',
						'placeholder'=>'Company'
					]) }}
					</div>
				</div>
				<!-- License Type -->
				<div class="form-group">
					<div class="col-sm-12">
					{{ Form::label('licensetype','License Type') }}
					{{ Form::select('licensetype',['Loading all License Types ...'],Input::old('licensetype'),[
						'id' => 'licensetype',
						'class' => 'form-control'
					]) }}
					</div>
				</div>
				<!-- Software types -->
				<div class="form-group">
					<div class="col-sm-12">
					{{ Form::label('softwaretype','Software Type') }}
					{{ Form::select('softwaretype',['Loading all Software Types ...'],Input::old('softwaretype'),[
						'id' => 'softwaretype',
						'class' => 'form-control'
					]) }}
					</div>
				</div>
				<!-- License -->
				<div class="form-group">
					<div class="col-sm-12">
					{{ Form::label('licensekey','License Key') }}
					{{ Form::text('licensekey',Input::old('licensekey'),[
						'class'=>'form-control',
						'placeholder'=>'License Key'
					]) }}
					</div>
				</div>
				<div class="col-sm-12">
					<div class="form-group">
            Multiple Usage
            <div class="material-switch pull-right">
                <input id="multiple" name="multiple" type="checkbox"/>
                <label for="multiple" class="label-success"></label>
            </div>
						<p style="font-size: 10px;"><span class="text-danger">Note:</span><span class="text-muted">Turning this off means that this license is for single use only</span></p>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="form-group">
						<button type="button" class="btn btn-primary col-md-offset-9 col-md-3" id="next">Next</button>
					</div>
				</div>
			</div>
			<div id="page-two">
				<div class="form-group">
					<!-- description -->
					<div class="col-sm-12">
						{{ Form::label('minrequirement','Software Minimum Requirements') }}
						{{ Form::textarea('minrequirement',Input::old('minrequirement'),[
							'class'=>'form-control',
							'placeholder'=>'Enter software minimum requirements here...',
							'data-autoresize',
							'rows' => '2'
						]) }}
					</div>
				</div>
				<div class="form-group">
					<!-- description -->
					<div class="col-sm-12">
						{{ Form::label('maxrequirement','Software Maximum Requirements') }}
						{{ Form::textarea('maxrequirement',Input::old('maxrequirement'),[
							'class'=>'form-control',
							'placeholder'=>'Enter software maximum requirements here...',
							'data-autoresize',
							'rows' => '2'
						]) }}
					</div>
				</div>
				<div class="form-group">
					<div class=" col-md-offset-6 col-md-3">
						<button type="submit" class="btn btn-primary btn-block">Create</button>
					</div>
					<div class="col-md-3">
						<button type="button" class="btn btn-default btn-block" id="previous">Previous</button>
					</div>
				</div>
			</div>
			{{ Form::close() }}
		</div>
	</div>
</div>
@stop
@section('script')
<script>
	$(document).ready(function(){

		$('#next').click(function(){
			$('#page-one').hide(400);
			$('#page-two').show(400);
		});

		$('#previous').click(function(){
			$('#page-two').hide(400);
			$('#page-one').show(400);
		});

		$.ajax({
			type: 'get',
			url: '{{ url("get/software/license/all") }}',
			dataType: 'json',
			success: function(response){
				options = "";
				for(ctr = 0;ctr<response.length;ctr++){
					options +=  `<option value="`+response[ctr]+`">`+response[ctr]+`</option>`;
				}
				$('#licensetype').html("");
				$('#licensetype').append(options);
			}
		});

		$.ajax({
			type: 'get',
			url: '{{ url("get/software/type/all") }}',
			dataType: 'json',
			success: function(response){
				options = "";
				for(ctr = 0;ctr<response.length;ctr++){
					options +=  `<option value="`+response[ctr]+`">`+response[ctr]+`</option>`;
				}
				$('#softwaretype').html("");
				$('#softwaretype').append(options);
			}
		});

		@if( Session::has("success-message") )
		  swal("Success!","{{ Session::pull('success-message') }}","success");
		@endif
		@if( Session::has("error-message") )
		  swal("Oops...","{{ Session::pull('error-message') }}","error");
		@endif

		jQuery.each(jQuery('textarea[data-autoresize]'), function() {
		    var offset = this.offsetHeight - this.clientHeight;

		    var resizeTextarea = function(el) {
		        jQuery(el).css('height', 'auto').css('height', el.scrollHeight + offset);
		    };
		    jQuery(this).on('keyup input', function() { resizeTextarea(this); }).removeAttr('data-autoresize');
		});

		$('#page-body').show();

	});
</script>
@stop
