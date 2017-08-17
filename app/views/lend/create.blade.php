@extends('layouts.master-blue')
@section('title')
Lending
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
{{ HTML::style(asset('css/jquery.timepicker.min.css')) }}
@stop
@section('script-include')
{{ HTML::script(asset('js/jquery.timepicker.min.js')) }}
@stop
@section('content')
<style>
	.panel-padding{
		padding: 10px;
	}
</style>
<div class="container-fluid">
	<div class="col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6">
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
		<div class="panel panel-body" style="padding:20px;">
			<legend><h3 style="color:#337ab7;">Lending Form</h3></legend>
			{{ Form::open(['class'=>'form-horizontal','method'=>'post','route'=>'lend.store','id'=>'reservationForm']) }}
			<!-- Item type -->
			<div class="form-group">
				<div class="col-sm-3">
				{{ Form::label('itemtype','Item type') }}
				</div>
				<div class="col-sm-9">
				{{ Form::select('type',$itemtype,Input::old('item'),[
					'id'=>'type',
					'class'=>'form-control'
				]) }}
				</div>	
			</div>
			<!-- Item name -->
			<div class="form-group">
				<div class="col-sm-3">
				{{ Form::label('itemname','Item name') }}
				</div>
				<div class="col-sm-9">
				{{ Form::select('itemname',['Empty list'=>'Empty list'],Input::old('itemname'),[
					'id'=>'itemname',
					'class'=>'form-control'
				]) }}
				</div>
			</div>
			<!-- Item name -->
			<div class="form-group">
				<div class="col-sm-3">
				{{ Form::label('property_number','Property Number') }}
				</div>
				<div class="col-sm-9">
				{{ Form::select('property_number',['Empty list'=>'Empty list'],Input::old('property_number'),[
					'id'=>'property_number',
					'class' => 'form-control'
				]) }}
				</div>
			</div>
			<!-- creator name -->
			<div class="form-group">
				<div class="col-sm-3">
				{{ Form::label('name','Faculty-in-charge') }}
				</div>
				<div class="col-sm-9">
				{{ Form::text('name',Input::old('name'),[
					'class'=>'form-control',
					'placeholder'=>'Faculty-in-charge'
				]) }}
				</div>
			</div>
			<!-- Location -->
			<div class="form-group">
				<div class="col-sm-3">
				{{ Form::label('location','Location') }}
				</div>
				<div class="col-sm-9">
				{{ Form::select('location',$room,Input::old('location'),[
					'class'=>'form-control'
				]) }}
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-12">
				{{ Form::button('Borrow',[
					'class'=>'btn btn-primary btn-block',
					'id'=>'request'
				]) }}
				</div>
			</div>
			{{ Form::close() }}
		</div>
	</div>
</div>
@stop
@section('script')
<script>
	$(function() {
		$( "#dateofuse" ).datepicker({
		  changeMonth: true,
		  changeYear: true,
		  maxAge: 59,
		  minAge: 15
		});
	});

	$('#type').change(function(){
		itemNameAjaxRequest();
	});

	$(document).ready(function(){
		$("#dateofuse").val('{{ $date }}');
		itemNameAjaxRequest();
	});

	function propertyNumberAjaxRequest(){
	var itemname = $('#itemname').val();
	$.ajax({
	  type: 'post',
	  url: '{{ url('/getAllPropertyNumber') }}',
	  data: {'itemname' : itemname}, 
	  dataType: 'json',
	  success: function(response){ 
	    options = "";
	    if(!$.trim(response))
	    {
	      options = "<option>Empty list</option>";

	    }else{
		    for(var ctr = 0;ctr<response.length;ctr++){
		    	if(response[ctr].length == 0)
		    	{
	      			options = "<option>Empty list</option>";
		    	}
		    	else
		    	{
		      		options += "<option value="+response[ctr].id+">"+response[ctr].property_number+"</option>";
		    	}
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

	function itemNameAjaxRequest(){
		var itemtype = $('#type').val();
		$.ajax({
			type: 'post',
			url: '{{ url('/getAllItemName') }}',
			data: {'itemtype' : itemtype}, 
			dataType: 'json',
			success: function(response){ 
			options = "";
			if(!$.trim(response))
			{
		  		options = "<option>Empty list</option>";

			}else{
			    for(var ctr = 0;ctr<response.length;ctr++){
			    	if(response[ctr].itemprofile.length > 0)
			    	{
			      		options += "<option value='"+response[ctr].itemname+"'>"+response[ctr].itemname+"</option>";
			    	}else{
		  				options = "<option>Empty list</option>";
			    	}
			    }
			}   
				$('#itemname').html(" ");
				$('#itemname').append(options);
				propertyNumberAjaxRequest();
			},
			error: function(response){
			console.log(response.responseJSON);
			}
		});
	}

	@if( Session::has("success-message") )
	  swal("Success!","{{ Session::pull('success-message') }}","success");
	@endif
	@if( Session::has("error-message") )
	  swal("Oops...","{{ Session::pull('error-message') }}","error");
	@endif

	$('#starttime').timepicker({
		timeFormat: 'h:mm p',
		interval: 30,
		minTime: '7',
		maxTime: '7:00pm',
		defaultTime: '7:00am',
		startTime: '7:00am',
		dynamic: false,
		dropdown: true,
		scrollbar: true
	});  

	$('#endtime').timepicker({
	    timeFormat: 'h:mm p',
	    interval: 30,
	    minTime: '8',
	    maxTime: '9:00pm',
	    defaultTime: '8:00am',
	    startTime: '8:00am',
	    dynamic: false,
	    dropdown: true,
	    scrollbar: true
	});

	$('#request').click(function(){
		swal({
		  title: "Are you sure?",
		  text: "By lending this equipment, you agreed to the policies and terms of the Laboratory Operations Office.",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonText: "Yes, borrow it!",
		  cancelButtonText: "No, cancel it!",
		  closeOnConfirm: false,
		  closeOnCancel: false
		},
		function(isConfirm){
		  if (isConfirm) {
				$("#reservationForm").submit();
		  } else {
		    swal("Cancelled", "Request Cancelled", "error");
		  }
		});
	});
</script>
@stop