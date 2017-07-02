@extends('layouts.master-blue')
@section('title')
Assign
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
   <div class="panel panel-body panel-shadow" style="padding: 30px 35px">
    <ol class="breadcrumb">
        <li>
            <a href="{{ url('workstation') }}">Workstation</a>
        </li>
            <li>
                <a href="{{ url('workstation/view/software') }}">Software Installed</a>
            </li>
        <li class="active">Assign</li>
    </ol>
		{{ Form::open(['method'=>'post','route'=>array('workstation.software.assign',$workstation->id),'class'=>'form-horizontal']) }}
    <div class="form-group">
      <div class=" col-md-12">
      {{ Form::label('workstationid','Workstation ID') }}
      {{ Form::text('workstationid',(count($workstation->id)> 0) ? $workstation->id: Input::old('workstation') ,[
          'class' => 'form-control',
          'style' => 'background-color: white;',
          'disabled',
          'readonly'
      ]) }}
      </div>
    </div>
    <div class="form-group">
      <div class=" col-md-12">
      {{ Form::label('software','Software') }}
      {{ Form::select('software',['Loading all values..'],Input::old('software'),[
          'id' => 'software',
          'class' => 'form-control'
      ]) }}
      </div>
    </div>
    <div class="form-group">
      <div class=" col-md-12">
      {{ Form::label('softwarelicense','Software License') }}
      {{ Form::select('softwarelicense',['Loading all values..'],Input::old('softwarelicense'),[
          'id' => 'softwarelicense',
          'class' => 'form-control'
      ]) }}
      </div>
    </div>
    <div class="form-group">
      <div class=" col-md-12">
        <button type="submit" class="btn btn-primary btn-lg btn-block">Assign</button>
        <a role="button" class="text-muted" style="font-size: 15px">Click me if you want to assign multiple software to a single workstation</a>
      </div>
    </div>
		{{ Form::close() }}
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

		init();

		function init()
		{
			software();
		}

		$('#software').on('change',function(){
			softwarelicense();
		});

		function software(){
			$.ajax({
				type: 'get',
				url: '{{ url("get/software/all/name") }}',
				dataType: 'json',
				success: function(response){
					option = "";
					for(ctr = 0; ctr < response.length; ctr++){
						option += `<option value='`+response[ctr].id+`'>`+response[ctr].name+`</option>`;
					}

					if(response.length == 0){
							$('#software').htm('<option>No record found</option>');
					}
					$('#software').html("");
					$('#software').append(option);
				},
				error: function(){
					$('#software').htm('<option>Error Retrieving Column</option>');
				},
				complete: function(){
					@if(Input::old('software'))
					$('#software').val('{{ Input::old('software') }}');
					@endif
					softwarelicense();
				}
			});
		}

		function softwarelicense(){
			$.ajax({
				type: 'get',
				url: '{{ url("get/software/license") }}' + '/' + $('#software').val() + '/key',
				dataType: 'json',
				success: function(response){
					option = "";
					for(ctr = 0; ctr < response.length; ctr++){
						option += `<option value='`+response[ctr].id+`'>`+response[ctr].key+`</option>`;
					}

					if(response.length == 0){
							$('#softwarelicense').htm('<option>No record found</option>');
					}
					$('#softwarelicense').html("");
					$('#softwarelicense').append(option);
				},
				error: function(){
					$('#softwarelicense').htm('<option>Error Retrieving Column</option>');
				},
				complete: function(){
					@if(Input::old('software'))
					$('#softwarelicense').val('{{ Input::old('softwarelicense') }}');
					@endif
				}
			});
		}

		$('#page-body').show();
	});
</script>
@stop
