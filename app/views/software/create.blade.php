@extends('layouts.master-blue')
@section('title')
Create
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
			<legend><h3 style="color:#337ab7;">Software Creation Form</h3></legend>
			{{ Form::open(['method'=>'post','route'=>'software.store','class'=>'form-horizontal']) }}
			<div class="col-md-12">
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
				<div class="form-group">
					<!-- description -->
					<div class="col-sm-12">
						{{ Form::label('description','Description') }}
						{{ Form::textarea('description',Input::old('description'),[
							'class'=>'form-control',
							'placeholder'=>'Enter software description here...'
						]) }}
					</div>
				</div> 
				<!-- Item name -->
				<div class="form-group">
					<div class="col-sm-12">
					{{ Form::label('licensetype','License Type') }}
					{{ Form::select('licensetype',$licensetype,Input::old('licensetype'),[
						'class' => 'form-control'
					]) }}
					</div>
				</div>
				<!-- Item name -->
				<div class="form-group">
					<div class="col-sm-12">
					{{ Form::label('softwaretype','Software type') }}
					{{ Form::select('softwaretype',$softwaretype,Input::old('softwaretype'),[
						'class' => 'form-control'
					]) }}
					</div>
				</div>
				<div class="form-group">
					<!-- description -->
					<div class="col-sm-12">
						{{ Form::label('requirement','Software Requirements') }}
						{{ Form::textarea('requirement',Input::old('requirement'),[
							'class'=>'form-control',
							'placeholder'=>'Enter software requirements here...'
						]) }}
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
					{{ Form::button('Cancel',[
						'class'=>'btn btn-info pull-right col-md-4 col-xs-4',
						'id'=>'cancel'
					]) }}
					{{ Form::submit('Create',[
						'class'=>'btn btn-primary pull-right col-md-4 col-xs-4'
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
<script>
	$('#cancel').click(function(){
		window.location.href ='{{ route('software.index') }}';
	});

	$('#itemname').change(function(){
	dynamicChange();
	});

	$(document).ready(function(){
	dynamicChange();
	});

	function dynamicChange(){
	var item = $('#itemname').val();
	if(item == "Empty list")
	{
    	options = "<option>Empty list</option>";
	    $('#property_number').html(" ");
	    $('#property_number').append(options);

	}else{
		$.ajax({
		  type: 'post',
		  url: '{{ url('/getAllPropertyNumber') }}',
		  data: {'item' : item}, 
		  dataType: 'json',
		  success: function(response){ 
		    options = "";

		    if(response.length == 0)
		    {
		    	options = "<option>Empty list</option>";
		    }else
		    {
			    for(var ctr = 0;ctr<response.length;ctr++){
			      options += "<option value="+response[ctr].id+">"+response[ctr].property_number+"</option>";
			    }   

		    } 
		    $('#property_number').html(" ");
		    $('#property_number').append(options);
		  },
		  error: function(response){
		    console.log(response.responseJSON);
		  }
		 });
		}
	}

	@if( Session::has("success-message") )
	  swal("Success!","{{ Session::pull('success-message') }}","success");
	@endif
	@if( Session::has("error-message") )
	  swal("Oops...","{{ Session::pull('error-message') }}","error");
	@endif
</script>
@stop