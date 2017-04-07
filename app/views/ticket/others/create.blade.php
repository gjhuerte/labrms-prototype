@extends('layouts.master-blue')
@section('title')
Others
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('content')
<style>
	.panel-padding{
		padding: 10px;
	}
</style>
<div class="container-fluid">
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
		<div class="panel panel-body">
			<legend><h3 style="color:#337ab7;">Generate Ticket</h3></legend>
			{{ Form::open(['class'=>'form-horizontal','id'=>'ticketingForm']) }}
			<div class="col-md-12">
				<!-- Title -->
				<div class="form-group">
					<div class="col-sm-12">
					{{ Form::label('title','Title') }}
					{{ Form::text('title',Input::old('title'),[
						'class'=>'form-control',
						'placeholder'=>'Ticket title'
					]) }}
					</div>
				</div>
				<div class="form-group">
					<!-- description -->
					<div class="col-sm-12">
						{{ Form::label('description','Details') }}
						{{ Form::textarea('description',Input::old('description'),[
							'class'=>'form-control',
							'placeholder'=>'Enter ticket details here...'
						]) }}
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
					{{ Form::button('Clear',[
						'class'=>'btn btn-info pull-right col-xs-4',
						'id'=>'clear'
					]) }}
					{{ Form::submit('Create',[
						'class'=>'btn btn-primary pull-right col-xs-4'
					]) }}
					</div>
				</div>
			</div>
		{{ Form::close() }}
		</div>
	</div>
</div>
@stop
@section('script')
<script type="text/javascript">

	$('#clear').click(function(){
		$('#ticketingForm').trigger('reset')
	});

	@if( Session::has("success-message") )
	  swal("Success!","{{ Session::pull('success-message') }}","success");
	@endif
	@if( Session::has("error-message") )
	  swal("Oops...","{{ Session::pull('error-message') }}","error");
	@endif
</script>
@stop