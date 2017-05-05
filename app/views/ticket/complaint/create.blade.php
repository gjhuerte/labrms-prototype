@extends('layouts.master-blue')
@section('title')
Complaint Ticket
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
			<legend><h3 style="color:#337ab7;">Generate Complaint Ticket</h3></legend>
			{{ Form::open(['class'=>'form-horizontal','id'=>'ticketingForm']) }}
			<div class="col-md-12">
				<!-- Room name -->
				<div class="form-group">
					<div class="col-sm-12">
					{{ Form::label('type','Room name') }}
					<select class="form-control" name="room" id="room">
					@if(count($rooms) == 0)
						<option>N / A</option>
					@else
						@foreach($rooms as $room)
						<option>{{ $room->name }}</option>
						@endforeach
					@endif
					</select>
					</div>
				</div>
				<!-- Item name -->
				<div class="form-group">
					<div class="col-sm-12">
					{{ Form::label('itemname','Item name') }}
					<select class="form-control" name="itemname" id="itemname">
					@if(count($inventory) == 0)
						<option>Empty list</option>
					@else
						@foreach($inventory as $item)
						<option value="{{ $item->itemname }}">{{ $item->itemname }}</option>
						@endforeach
					@endif
					</select>
					</div>
				</div>
				<!-- Item name -->
				<div class="form-group">
					<div class="col-sm-12">
					{{ Form::label('property_number','Property Number') }}
					<select class="form-control" name="property_number" id="property_number">
						<option>Empty list</option>	
					</select>
					</div>
				</div>
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

	$(document).ready(function(){
		propertyChange();
	});

	$('#itemname,#room').change(function(){
		propertyChange();
	});

	function propertyChange(){
	var item = $('#itemname').val();
	var room = $('#room').val();
	if(item == "Empty list" || room == 'Empty list')
	{
    	options = "<option>Empty list</option>";
	    $('#property_number').html(" ");
	    $('#property_number').append(options);

	}else{
		$.ajax({
			type: 'post',
			url: '{{ url('/getAllItemsAssignedToThisRoom') }}',
			data: {
					'item' : item,
					'room' : room
					}, 
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

	$('#clear').click(function(){
		$('#ticketingForm').trigger('reset');
	});

  	@if( Session::has("success-message") )
	  swal("Success!","{{ Session::pull('success-message') }}","success");
	@endif
	@if( Session::has("error-message") )
	  swal("Oops...","{{ Session::pull('error-message') }}","error");
	@endif
</script>
@stop