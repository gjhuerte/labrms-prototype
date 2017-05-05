@extends('layouts.master-blue')
@section('title')
Action Taken
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
			<legend><h3 style="color:#337ab7;">Action Taken Ticket</h3></legend>
			{{ Form::open(['class'=>'form-horizontal','id'=>'ticketingForm']) }}
			<div class="col-md-12">
				<!-- item name -->
				<div class="form-group">
					<div class="col-sm-12">
					{{ Form::label('incident','Incident Name') }}
					<select class="form-control" name="incident">
					@if(count($incidents) == 0)
						<option>No incident / complaints recorded</option>
					@else
						@foreach($incidents as $incident)
						<option value="{{ $incident->id }}">{{{ $incident->title }}} {{{ (count($incident->itemprofile) > 0 || $incident->itemprofile != null || !empty($incident->itemprofile)) ? '- '.$incident->itemprofile->property_number : "" }}}</option>
						@endforeach
					@endif
					</select>
					</div>			
				</div>
			@if(count($incidents) != 0)
				<div class="form-group">
					<!-- description -->
					<div class="col-sm-12">
						{{ Form::label('description','Details') }}
						{{ Form::textarea('description',Input::old('description'),[
							'class'=>'form-control',
							'placeholder'=>'Enter action taken details here...'
						]) }}
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
					{{ Form::button('Clear',[
						'class'=>'btn btn-sm btn-info pull-right col-xs-4',
						'id'=>'clear'
					]) }}
					{{ Form::submit('Create',[
						'class'=>'btn btn-sm btn-primary pull-right col-xs-4'
					]) }}
					</div>
				</div>
				@endif
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