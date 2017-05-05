@extends('layouts.master-white')
@section('title')
Show
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
<style>
  .panel{
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
  }
</style>
@stop
@section('content')
<div class="container-fluid" id="page-body" hidden style="padding : 0;margin: 0;">
	<div class="col-sm-offset-2 col-sm-8">
	@if(count($person) > 0)
		<div class="panel">
			<div class="panel-body">
				<div class="col-xs-12 col-sm-12">
					<legend><h1 class="text-muted"><strong>Profile</strong></h1></legend>	
				</div>
				<div class="col-sm-4">
					<img src="{{ asset('images/profile/blank-profile-picture-logo.png') }}" alt="Profile Picture" class="img-responsive img-rounded">
					<button class="btn btn-info btn-block">Update</button>
					<h3 class="text-center text-muted" style="letter-spacing: 5px">{{ $person->firstname }} {{ $person->lastname }} </h3>
					<h4 class="text-center text-info" style="letter-spacing: 5px">{{ $person->type }}</h4>
				</div>
				<div class="col-sm-4">
					<legend><h4 class="text-muted">Other Info</h4></legend>
					<h4 class="text-primary" style="letter-spacing: 2px">{{ $person->contactnumber }}</h4>
					<h4 class="text-primary" style="letter-spacing: 2px">{{ $person->email }}</h4>
					<h4 class="text-primary" style="letter-spacing: 2px">Last Update: {{ Carbon\Carbon::parse($person->updated_at)->toFormattedDateString() }}</h4>
					@if($person->status == 0)
					<h4 class="text-danger" style="letter-spacing: 2px">Status: Inactive</h4>
					@else
					<h4 class="text-success" style="letter-spacing: 2px">Status: Active</h4>
					@endif
				</div>
				<div class="col-sm-4">
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
