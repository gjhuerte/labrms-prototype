@extends('layouts.master-blue')
@section('title')
Dashboard
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')

	{{ HTML::style(asset('css/fullcalendar.min.css')) }}
	{{ HTML::style(asset('css/fullcalendar.print.min.css',['media'=>'print'])) }}
@stop
@section('script-include')
	{{ HTML::script(asset('js/moment.min.js')) }}	
	{{ HTML::script(asset('js/fullcalendar.min.js')) }}
	{{ HTML::script(asset('js/gcal.min.js')) }}
@stop
@section('content')
<div class="container-fluid">
	<div class="col-md-3" id="accordion" role="tablist" aria-multiselectable="true">
		<div class="panel panel-info">
			<div class="panel-heading" role="tab" id="headingOne">
				<div class="panel-title">
				    <a role="button">
				      Reservation list
				    </a>
				</div>
			</div>
			<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne" style="margin-bottom: 0;padding-bottom:0;">
			@foreach($reservations as $reservation)
				@if(count($reservation->itemprofile) > 0)
			    <a href="{{ route('reservation.show',$reservation->id) }}" class="list-group-item">
			      <h4 class="list-group-item-heading">
					@if(Carbon\Carbon::parse($reservation->dateofuse) == Carbon\Carbon::tomorrow())
		      		<p class="text-warning">
			    	@elseif(Carbon\Carbon::parse($reservation->dateofuse) >  Carbon\Carbon::tomorrow() )
		      		<p class="text-success">
			    	@elseif(Carbon\Carbon::parse($reservation->dateofuse) == Carbon\Carbon::today() )
		      		<p class="text-danger">
			    	@endif
		      			{{ Carbon\Carbon::parse($reservation->dateofuse)->toFormattedDateString() }} 
			      		@if($reservation->approval == 1)
			      		<span class="label label-success">Approved</span>
			      		@elseif($reservation->approval == 2)
			      		<span class="label label-danger">Disapproved</span>
			      		@elseif($reservation->approval == 0)
			      		<span class="label label-info">Undecided</span>
			      		@endif
		      		</p>
			      </h4>


			      @if(count($reservation->itemprofile) > 0)
			      <p class="list-group-item-text">Item Name: {{{ $reservation->itemprofile->inventory->itemname }}} </p>
			      <p class="list-group-item-text">Property Number: {{{ $reservation->itemprofile->property_number }}} </p>
			      @endif

			      <p class="list-group-item-text">Purpose: {{{ $reservation->purpose }}}</p>
			    </a>
			    @endif
			@endforeach
			</div>
        </div> <!-- end of notification tab -->
		{{ $reservations->links() }}
	</div>
	<div class=" col-md-6">
		<div class="col-sm-12 panel panel-body"  id='calendar'>
			<div></div>
		</div>
	</div>
	<div class="col-md-3" id="accordion" role="tablist" aria-multiselectable="true">
		<div class="panel panel-primary">
			<div class="panel-heading" role="tab" id="headingOne">
				<div class="panel-title">
				    <a role="button">
				      Ticket list
				    </a>
				</div>
			</div>
			<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne" style="margin-bottom: 0;padding-bottom:0;">
			@foreach($tickets as $ticket)
				@if(count($ticket->itemprofile) > 0)
					@if( count($ticket->actiontaken) > 0 )
				    <a href="{{ route('ticket.actiontaken.show',$ticket->id) }}" class="list-group-item">
				    @else
				    <a href="#" class="list-group-item">
				    @endif
					@if($ticket->type == 'maintenance')
				      <h4 class="list-group-item-heading"><p class="text-warning">{{{ $ticket->title }}}</p></h4>
				    @elseif($ticket->type == 'receive')
				      <h4 class="list-group-item-heading"><p class="text-success">{{{ $ticket->title }}}</p></h4>
				    @elseif($ticket->type == 'complaint' || $ticket->type == 'incident')
				      <h4 class="list-group-item-heading"><p class="text-danger">{{{ $ticket->title }}}
				      </p></h4>
				    @else
				      <h4 class="list-group-item-heading"><p class="text-info">{{{ $ticket->title }}}</p></h4>
				    @endif

		   		 	@if( count($ticket->itemprofile) > 0)
					  <p class="list-group-item-text">Item Name: {{{ $ticket->itemprofile->inventory->itemname }}} </p>
					@else
					  <p class="list-group-item-text">Item Condemned </p>
					@endif
					  <p class="list-group-item-text">Description: {{{ $ticket->description }}}</p>
					  	@if(count($ticket->actiontaken) > 0)
							@foreach($ticket->actiontaken as $action)
					  	 	<span class="label label-success">Resolved</span>
							@endforeach
						@endif
				    </a>
			    @endif
			@endforeach
			</div> 
        </div> <!-- end of notification tab -->
		{{ $tickets->links() }}
	</div>
</div>
@stop
@section('script')
<script type="text/javascript">	
$(document).ready(function() {
		
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

			defaultView: 'month',
			defaultDate: '{{ Carbon\Carbon::now()->toDateString() }}',
			navLinks: true, // can click day/week names to navigate views
			editable: true,
			eventLimit: true, // allow "more" link when too many events
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
		
	});
	@if( Session::has("success-message") )
	  swal("Success!","{{ Session::pull('success-message') }}","success");
	@endif
	@if( Session::has("error-message") )
	  swal("Oops...","{{ Session::pull('error-message') }}","error");
	@endif
</script>
@stop