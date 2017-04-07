@extends('layouts.master-blue')
@section('title')
Complaints
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
				<h3>Item Profile</h3>
			</div>
			<div class="panel-body" style="margin-bottom: 10px;">
				<div class="col-sm-12">
					{{ Form::button(' <<< Go back ',[
						'class' => 'btn btn-sm btn-link pull-right',
						'id' => 'back'
					]) }}
				</div>
			@if(count($item->itemprofile->inventory) > 0)
				<div class="col-sm-4">
					<label class="text-primary">Item Name</label>
				</div>
				<div class="col-sm-8">
					<p class="form-control">{{ $item->itemprofile->inventory->itemname }}</p>
				</div>
			@endif
				<div class="col-sm-4">
					<label class="text-primary">Property Number</label>
				</div>
				<div class="col-sm-8">
					<p class="form-control">{{ $item->itemprofile->property_number }}</p>
				</div>
				<div class="col-sm-4">
					<label class="text-primary">Serial ID</label>
				</div>
				<div class="col-sm-8">
					<p class="form-control">{{ $item->itemprofile->serialid }}</p>
				</div>
				<div class="col-sm-4">
					<label class="text-primary">MR Number</label>
				</div>
				<div class="col-sm-8">
					<p class="form-control">{{ $item->itemprofile->MR_no }}</p>
				</div>
				<div class="col-sm-4">
					<label class="text-primary">Status</label>
				</div>
				<div class="col-sm-8">
					<p class="form-control">{{ $item->itemprofile->status }}</p>
				</div>
				<div class="col-sm-4">
					<label class="text-primary">Location</label>
				</div>
				<div class="col-sm-8">
					<p class="form-control">{{ $item->itemprofile->location }}</p>
				</div>
				@if( count($item->actiontaken) > 0)
					<div class="col-sm-12">
						<label class="text-primary">Problem Title</label>
					</div>
					<div class="col-sm-12">
						<p class="form-control">{{ $item->title }}</p>
					</div>
				@endif
				@if( count($item->actiontaken) > 0)
					@foreach($item->actiontaken as $item)
					<div class="col-sm-12">
						<label class="text-primary">Action Taken</label>
					</div>
					<div class="col-sm-12">
						<p class="form-control">{{ $item->description }}</p>
					</div>
					@endforeach
				@endif
			</div>
		</div>
	@endif
	</div>
</div>
@stop
@section('script')
<script type="text/javascript">
	$('#back').click(function(){
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
