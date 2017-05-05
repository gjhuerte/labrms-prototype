@extends('layouts.master-blue')
@section('title')
Show
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('content')
<div class="container-fluid">
	<div class="col-md-offset-3 col-md-6">
	@if(count($item) > 0)
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3>Equipment Profile</h3>
			</div>
			<div class="panel-body" style="margin-bottom: 10px;">
				<div class="col-sm-4">
					<label class="text-primary">Property Number</label>
				</div>
				<div class="col-sm-8">
					<p class="form-control">{{ $item->property_number }}</p>
				</div>
				<div class="col-sm-4">
					<label class="text-primary">Serial ID</label>
				</div>
				<div class="col-sm-8">
					<p class="form-control">{{ $item->serialid }}</p>
				</div>
				<div class="col-sm-4">
					<label class="text-primary">MR Number</label>
				</div>
				<div class="col-sm-8">
					<p class="form-control">{{ $item->MR_no }}</p>
				</div>
				<div class="col-sm-4">
					<label class="text-primary">Status</label>
				</div>
				<div class="col-sm-8">
					<p class="form-control">{{ $item->status }}</p>
				</div>
				<div class="col-sm-4">
					<label class="text-primary">Location</label>
				</div>
				<div class="col-sm-8">
					<p class="form-control">{{ $item->location }}</p>
				</div>
				<div class="col-md-12">
					<div class="pull-right">
					{{ Form::open(['method'=>'delete','route'=>array('item.profile.destroy',$item->id)]) }}	
					{{ Form::submit('Condemn',[
						'class' => 'btn btn-warning',
						'name' => 'delete'
					]) }}
					{{ Form::close() }}
					</div>
					<div class="pull-right">
					{{ Form::open(['method'=>'get','route'=>array('item.profile.edit',$item->id)]) }}
					{{ Form::submit('Transfer',[
						'class'=>'btn btn-success',
						'name' => 'transfer'
					]) }}
					{{ Form::close() }}
					</div>
					<div class="pull-right">
					{{ Form::open(['method'=>'get','route'=>array('item.profile.edit',$item->id)]) }}
					{{ Form::submit('Update',[
						'class'=>'btn btn-primary',
						'name' => 'update'
					]) }}
					{{ Form::close() }}
					</div>
				</div>
				<div class="col-md-12" style="padding-top: 20px;">
					<a class="btn-link" role="button" data-toggle="collapse" href="#complaintCOllapse" aria-expanded="false" aria-controls="complaintCOllapse">
					  <legend><strong class="text-primary">Complaints</strong></legend>
					</a>
					<div class="collapse" id="complaintCOllapse">
					  <div class="well">
					  	@foreach( $item->ticket as $ticket )
						    @if($ticket->type == 'complaint' || $ticket->type == 'incident')
						    <a href="#" class="list-group-item">
						      <h4 class="list-group-item-heading"><p class="text-danger">{{{ $ticket->title }}}</p></h4>
					   		 	@if( count($ticket->itemprofile) > 0)
								  <p class="list-group-item-text">Date: {{{ Carbon\Carbon::parse($ticket->created_at)->toFormattedDateString() }}} </p>
								@endif
								  <p class="list-group-item-text">Description: {{{ $ticket->description }}}</p>
						    </a>
						    @endif
					    @endforeach
					  </div>
					</div>
				</div>
				<hr />
				<div class="col-md-12" style="padding-top: 20px;">
					<a class="btn-link" role="button" data-toggle="collapse" href="#historyCollapse" aria-expanded="false" aria-controls="historyCollapse">
					  <legend><strong class="text-primary">History</strong></legend>
					</a>
					<div class="collapse" id="historyCollapse">
					  <div class="well">
					  	@foreach( $item->ticket as $ticket )
							@if($ticket->type == 'maintenance')
						    <a href="#" class="list-group-item">
						      <h4 class="list-group-item-heading"><p class="text-warning">{{{ $ticket->title }}}</p></h4>
					   		 	@if( count($ticket->itemprofile) > 0)
								  <p class="list-group-item-text">Date: {{{ Carbon\Carbon::parse($ticket->created_at)->toFormattedDateString() }}} </p>
								@endif
								  <p class="list-group-item-text">Description: {{{ $ticket->description }}}</p>
						    </a>
						    @elseif($ticket->type == 'receive')
						    <a href="#" class="list-group-item">
						      <h4 class="list-group-item-heading"><p class="text-success">{{{ $ticket->title }}}</p></h4>
  					   		 	@if( count($ticket->itemprofile) > 0)
								  <p class="list-group-item-text">Date: {{{ Carbon\Carbon::parse($ticket->created_at)->toFormattedDateString() }}} </p>
								@endif
								  <p class="list-group-item-text">dscDescription: {{{ $ticket->description }}}</p>
								  	@if(count($ticket->actiontaken) > 0)
										@foreach($ticket->actiontaken as $action)
								 		 <p class="list-group-item-text">Action taken: {{{ $ticket->actiontaken->description }}}</p>
										@endforeach
									@endif
						    </a>
						    @endif
					    @endforeach
					  </div>
					</div>
				</div>
			</div>
		</div>
	@endif
	</div>
</div>
@stop
@section('script')
<script type="text/javascript">
	@if( Session::has("success-message") )
	  swal("Success!","{{ Session::pull('success-message') }}","success");
	@endif
	@if( Session::has("error-message") )
	  swal("Oops...","{{ Session::pull('error-message') }}","error");
	@endif
</script>
@stop
