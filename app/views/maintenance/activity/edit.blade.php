@extends('layouts.master-blue')
@section('title')
Edit
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
<link rel="stylesheet" href="{{ asset('css/style.min.css') }}" />
<style>
	#page-body{
		display:none;
	}
</style>
@stop
@section('content')
<div class="container-fluid" id="page-body">
	<div class='col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6'>
		<div class="panel panel-body ">
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
			<ol class="breadcrumb">
			  <li><a href="{{ url('maintenance/activity') }}">Maintenance Activity</a></li>
			  <li class="active">{{ $equipmentsupport->id }}</li>
			</ol>
			{{ Form::open(['method'=>'put','route'=>array('equipment.support.update',$equipmentsupport->id),'class'=>'form-horizontal']) }}

				<!-- Title -->
				<div class="form-group">
					<div class="col-sm-12">
					{{ Form::label('type','Maintenance Type') }}
					</div>
          <div class="col-sm-6">
              <input type="radio" name="maintenancetype" id='corrective' value='corrective' checked/> Corrective
          </div>
          <div class="col-sm-6">
              <input type="radio" name="maintenancetype" id="preventive" value='preventive' /> Preventive
          </div>
				</div>
				<!-- Company -->
				<div class="form-group">
					<div class="col-sm-12">
					{{ Form::label('problem','Problem / Category') }}
					{{ Form::textarea('problem',Input::old('problem'),[
            'id' => 'problem',
						'class'=>'form-control',
						'placeholder'=>'Problem or Category under the said type'
					]) }}
					</div>
				</div>
				<div class="form-group">
					<div class=" col-md-12">
						<button type="submit" class="btn btn-lg btn-primary btn-block">Update</button>
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

		@if( Session::has("success-message") )
		  swal("Success!","{{ Session::pull('success-message') }}","success");
		@endif
		@if( Session::has("error-message") )
		  swal("Oops...","{{ Session::pull('error-message') }}","error");
		@endif

    @if($equipmentsupport->type == 'corrective')
      $('#corrective').attr('checked','checked');
    @else
        $('#preventive').attr('checked','checked');
    @endif

    $('#problem').val("{{ $equipmentsupport->problem }}");

		$('#page-body').show();

	});
</script>
@stop
