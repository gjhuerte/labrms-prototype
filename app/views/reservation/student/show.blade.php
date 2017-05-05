@extends('layouts.master-blue')
@section('title')
Reservation Information
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('content')
<div class="container-fluid">
	<div class="col-md-offset-3 col-md-6">
	@if(count($reservation) > 0)
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3>Reservation Information
			      		@if($reservation->approval == 1)
			      		<span class="label label-success">Approved</span>
			      		@elseif($reservation->approval == 2)
			      		<span class="label label-danger">Disapproved</span>
			      		@elseif($reservation->approval == 0)
			      		<span class="label label-info">Undecided</span>
			      		@endif
	      		</h3>
			</div>
			<div class="panel-body" style="margin-bottom: 10px;">
				<legend><strong class="text-primary">Reservation Date:  {{ Carbon\Carbon::parse($reservation->dateofuse)->toFormattedDateString() }}</strong> 
					{{ Form::button('<<< Go Back',[
						'class'=>'btn-link btn-warning btn-sm pull-right',
						'id' => 'return'
					]) }}</legend>
				<div class="col-sm-4">
					<label class="text-primary">From</label>
				</div>
				<div class="col-sm-8">
					<p class="form-control">{{ Carbon\Carbon::parse($reservation->timein)->format('h:i A') }}</p>
				</div>
				<div class="col-sm-4">
					<label class="text-primary">To</label>
				</div>
				<div class="col-sm-8">
					<p class="form-control">{{ Carbon\Carbon::parse($reservation->timeout)->format('h:i A') }}</p>
				</div>
				<div class="col-sm-4">
					<label class="text-primary">Borrower</label>
				</div>
				<div class="col-sm-8">
					<p class="form-control">{{ $reservation->user->firstname }} {{ $reservation->user->lastname}}</p>
				</div>
				<div class="col-sm-4">
					<label class="text-primary">Item</label>
				</div>
				<div class="col-sm-8">
					@if( count( $reservation->itemprofile ) > 0)
					<p class="form-control">{{ $reservation->itemprofile->inventory->itemname }} - {{ $reservation->itemprofile->property_number }}</p>
					@else
					<p class="form-control">Item disposed</p>
					@endif
				</div>
				<div class="col-sm-4">
					<label class="text-primary">Purpose</label>
				</div>
				<div class="col-sm-8">
					<p class="form-control">{{ $reservation->purpose }}</p>
				</div>
				<div class="col-sm-4">
					<label class="text-primary">Location</label>
				</div>
				<div class="col-sm-8">
					<p class="form-control">{{{ $reservation->location }}}</p>
				</div>
				<div class="col-sm-4">
					<label class="text-primary">Faculty-in-charge</label>
				</div>
				<div class="col-sm-8">
					<p class="form-control">{{ $reservation->facultyincharge }}</p>
				</div>
				<div class="col-md-12">
					@if(Auth::user()->accesslevel == '1' || Auth::user()->accesslevel == '0')
					@if($reservation->approval == 1)	
					<div class="pull-right">
					{{ Form::open(['method'=>'delete','route'=>array('reservation.destroy',$reservation->id),'id'=>'cancelForm']) }}
					{{ Form::button('Cancel',[
						'id'=>'cancel',
						'class'=>'btn btn-danger btn-sm',
						'name'=>'cancel'
					]) }}
					{{ Form::close() }}
					</div>
					@elseif($reservation->approval == 0)
					<div class="pull-right">
					{{ Form::open(['method'=>'put','route'=>array('reservation.update',$reservation->id)]) }}
					{{ Form::submit('Disapprove',[
						'class'=>'btn btn-info btn-sm',
						'name'=>'disapprove'
					]) }}
					{{ Form::close() }}
					</div>
					<div class="pull-right">
					{{ Form::open(['method'=>'put','route'=>array('reservation.update',$reservation->id)]) }}
					{{ Form::submit('Approve',[
						'class'=>'btn btn-primary btn-sm',
						'name'=>'approve'
					]) }}
					{{ Form::close() }}
					</div>
					@endif
				</div>
				@endif
			</div>
		</div>
	@endif
	</div>
</div>
@stop
@section('script')
<script type="text/javascript">
	$('#cancel').click(function(){
		swal({
		  title: "Are you sure?",
		  text: "Do you really want to cancel this reservation?",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonColor: "#DD6B55",
		  confirmButtonText: "Yes, cancel it!",
		  cancelButtonText: "No, go back!",
		  closeOnConfirm: false,
		  closeOnCancel: false
		},
		function(isConfirm){
		  if (isConfirm) {
				$("#cancelForm").submit();
		  } else {
		    swal("Cancelled", "Request Cancelled", "error");
		  }
		});
	});

	$('#return').click(function(){
		window.location.href = '{{ route("dashboard.index") }}';
	});
	@if( Session::has("success-message") )
	  swal("Success!","{{ Session::pull('success-message') }}","success");
	@endif
	@if( Session::has("error-message") )
	  swal("Oops...","{{ Session::pull('error-message') }}","error");
	@endif
</script>
@stop
