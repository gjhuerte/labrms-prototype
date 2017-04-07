@extends('layouts.master-blue')
@section('title')
Reservation
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
	{{ HTML::style(asset('css/_materialFullCalendar.scss')) }}
	{{ HTML::style(asset('css/fullcalendar.min.css')) }}
	{{ HTML::style(asset('css/fullcalendar.print.min.css',['media'=>'print'])) }}
	{{ HTML::style(asset('css/jquery.timepicker.min.css')) }}
@stop
@section('script-include')
	{{ HTML::script(asset('js/moment.min.js')) }}	
	{{ HTML::script(asset('js/fullcalendar.min.js')) }}
	{{ HTML::script(asset('js/gcal.min.js')) }}
	{{ HTML::script(asset('js/jquery.timepicker.min.js')) }}
@stop
@section('content')
<style>
	#calendar-panel, #hide{
		display:none;
	}
	.panel-padding{
		padding: 10px;
	}
</style>
<div class="container-fluid" id="page-body" hidden>
	<div class="col-md-6"  id='calendar-panel'>
		<div id="calendar" class="panel panel-body"></div>
	</div>
	<div class="col-md-offset-3 col-md-6 panel panel-body" id="pagebody" style="padding: 10px;">
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
		<div class="" style="padding:20px;">
			<legend>
				<h3 style="color:#337ab7;">Reservation Form
				{{ Form::button('Show Calendar',[
					'class'=>'pull-right btn btn-link btn-primary',
					'id' => 'show'
				]) }}
				{{ Form::button('Hide Calendar',[
					'class'=>'pull-right btn btn-link btn-primary',
					'id' => 'hide'
				]) }}
				</h3>
			</legend>
			{{ Form::open(['class'=>'form-horizontal','method'=>'post','route'=>'reservation.store','id'=>'reservationForm']) }}
			<!-- date of use -->
			<div class="form-group">
				<div class="col-sm-3">
				{{ Form::label('dateofuse','Date of Use') }}
				</div>
				<div class="col-sm-9">
				{{ Form::text('dateofuse',Input::old('dateofuse'),[
					'class'=>'form-control',
					'placeholder'=>'MM | DD | YYYY',
					'readonly',
					'style'=>'background-color: #ffffff	'
				]) }}
				</div>
			</div>
			<!-- time started -->
			<div class="form-group">
				<div class="col-sm-3">
				{{ Form::label('time_start','Time started') }}
				</div>
				<div class="col-sm-9">
				{{ Form::text('time_start',Input::old('time_start'),[
					'class'=>'form-control',
					'placeholder'=>'Hour : Min',
					'id' => 'starttime',
					'readonly',
					'style'=>'background-color: #ffffff	'
				]) }}
				</div>
			</div>
			<!-- time_end -->
			<div class="form-group">
				<div class="col-sm-3">
				{{ Form::label('time_end','Time end') }}
				</div>
				<div class="col-sm-9">
				{{ Form::text('time_end',Input::old('time_end'),[
					'class'=>'form-control background-white',
					'placeholder'=>'Hour : Min',
					'id' => 'endtime',
					'readonly',
					'style'=>'background-color: #ffffff	'
				]) }}
				</div>
			</div>
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
			<!-- Purpose -->
			<div class="form-group">
				<div class="col-sm-3">
				{{ Form::label('purpose','Purpose') }}
				</div>
				<div class="col-sm-9">
				{{ Form::select('purpose',$purpose,Input::old('purpose'),[
					'class'=>'form-control'
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
				{{ Form::button('Request',[
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
	$(document).ready(function(){

		@if( Session::has("success-message") )
		  swal("Success!","{{ Session::pull('success-message') }}","success");
		@endif
		@if( Session::has("error-message") )
		  swal("Oops...","{{ Session::pull('error-message') }}","error");
		@endif

		$('#page-body').slideDown(600);

		$('#show').click(function(){
				$('#pagebody').removeClass('col-md-offset-3');
				$('#hide').show(0);
				$('#show').hide(400);
				$('#calendar-panel').fadeIn(400);
				$('#calendar').fullCalendar('render');	
		});

		$('#hide').click(function(){
				$('#pagebody').addClass('col-md-offset-3');
				$('#show').show(400);
				$('#hide').hide(400);
				$('#calendar-panel').fadeOut(0);
		});

		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'listDay,listWeek,month'
			},

			// customize the button names,
			// otherwise they'd all just say "list"
			views: {
				listDay: { buttonText: 'list day' },
				listWeek: { buttonText: 'list week' }
			},

			defaultDate: '{{ Carbon\Carbon::now()->toDateString() }}',
			navLinks: true, // can click day/week names to navigate views
			editable: true,
			eventLimit: true, // allow "more" link when too many events	
			theme: true,
			events: [
				@foreach($reservations as $reservation)
					@if($reservation->approval != '2' && count($reservation->itemprofile) > 0)
				{
					title: '{{ $reservation->itemprofile->inventory->itemname }}: {{ $reservation->itemprofile->property_number }}',
					url: '{{ route('reservation.show',$reservation->id) }}',
					start: '{{ Carbon\Carbon::parse($reservation->dateofuse." ".$reservation->timein) }}',
					end: '{{ Carbon\Carbon::parse($reservation->dateofuse." ".$reservation->timeout) }}'
				},
					@endif
				@endforeach
			]
		});

		$(function() {
			$( "#dateofuse" ).datepicker({
			  changeMonth: true,
			  changeYear: false,
			  maxAge: 59,
			  minAge: 15,
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
				      		options += "<option value='"+response[ctr].itemname+"'>"+response[ctr].itemname+"</option>";
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
			  text: "By submitting a request, you acknowledge our condition of three(3) working days in item reservation unless there is a special event or non-working holidays. Disregarding this notice decreases your chance of approval",
			  type: "warning",
			  showCancelButton: true,
			  confirmButtonColor: "#DD6B55",
			  confirmButtonText: "Yes, submit it!",
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

	});
</script>
@stop