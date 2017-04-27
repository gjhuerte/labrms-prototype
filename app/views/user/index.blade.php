@extends('layouts.master-blue')
@section('title')
Show
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
<style>
	#page-body{
		display: none;
	}
</style>
@stop
@section('content')
<div class="container" id="page-body">
	<div class="col-sm-offset-2 col-sm-8">
	@if(count($person) > 0)
		<div class="panel">
			<div class="panel-body">
				<div class="col-xs-12 col-sm-12">
					<legend><h1 class="text-muted"><strong>Profile</strong></h1></legend>	
				</div>
				<div class="col-sm-4">
					@if(Auth::user()->accesslevel == 0)
					<img src="{{ asset('images/logo/LabHead/labhead-icon-32.png') }}" alt="Profile Picture" class="img img-responsive img-circle">
					@elseif(Auth::user()->accesslevel == 1)
					@elseif(Auth::user()->accesslevel == 2)
					@elseif(Auth::user()->accesslevel == 3)
					@elseif(Auth::user()->accesslevel == 4)
					@endif
					<h4 class="text-center text-info" style="letter-spacing: 5px">{{ $person->type }}</h4>
					@if($person->status == 0)
					<h4 class="text-center text-danger" style="letter-spacing: 2px">Inactive</h4>
					@else
					<h4 class="text-center text-success" style="letter-spacing: 2px">Active</h4>
					@endif
				</div>
				<div class="col-sm-offset-1 col-sm-6">
					<h3 class="text-primary text-capitalize">{{ $person->firstname }} {{ $person->lastname }} </h3>
					<h4 class="text-muted"">{{ $person->contactnumber }}</h4>
					<h4 class="text-muted">{{ $person->email }}</h4>
					<h4 class="text-muted">Last Update: {{ Carbon\Carbon::parse($person->updated_at)->toFormattedDateString() }}</h4>
				</div>
				<div class="col-sm-12" style="padding-top: 20px;">
					<legend><h4 class="text-muted">Summary</h4></legend>
					<p class="bg-success text-success" style="padding: 10px;">Incident Fixed:</p>
					<p class="bg-primary text-primary" style="padding: 10px;">Pending Complaints:</p>
					<p class="bg-info text-info" style="padding: 10px;">Unfixed Complaints:</p>
					<p class="bg-warning text-warning" style="padding: 10px;">Complaints Generated:</p>
					<p class="bg-danger text-danger" style="padding: 10px;">Penalty:</p>
				</div>

				<div class="clearfix col-sm-12">
					<button class="btn btn-sm btn-danger pull-right">Report</button>
					<button class="btn btn-sm btn-primary pull-right">Submit Bug Report</button>
					<button class="btn btn-sm btn-info pull-right">Deactivate</button>
					<button class="btn btn-sm btn-success pull-right">Request Update</button>
				</div>
			</div>
		</div>
	@else
	<p class="text-muted">No Profile to Display</p>
	@endif
	</div>
</div>
@stop
@section('script')
<script type="text/javascript">
	$(document).ready(function(){
		@if( Session::has("success-message") )
		  swal("Success!","{{ Session::pull('success-message') }}","success");
		@endif
		@if( Session::has("error-message") )
		  swal("Oops...","{{ Session::pull('error-message') }}","error");
		@endif
		$('#page-body').show();
	});
</script>
@stop
