@extends('layouts.master-blue')
@section('title')
Show
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('content')
<div class="container-fluid" id="page-body" hidden>
	<div class="col-md-offset-3 col-md-6">
	@if(count($person) > 0)
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3>User Profile</h3>
			</div>
			<div class="panel-body" style="margin-bottom: 10px;">
				<div class="col-sm-4">
					<h3 class="text-primary">Full Name:</h3>
				</div>
				<div class="col-sm-8">
					<h3 class="text-primary">{{ $person->firstname }} {{ $person->middlename }} {{ $person->lastname }}</h3>
				</div>
				<div class="col-md-12" style="padding-top: 20px;">
					<a class="btn-link" role="button" data-toggle="collapse" href="#complaintCOllapse" aria-expanded="false" aria-controls="complaintCOllapse">
					  <legend><strong class="text-primary">Complaints</strong></legend>
					</a>
					<div class="collapse" id="complaintCOllapse">
					    <a href="#" class="list-group-item">
					      <h4 class="list-group-item-heading"><p class="text-danger"></p></h4>
							  <p class="list-group-item-text"></p>
							  <p class="list-group-item-text"></p>
					    </a>
					</div>
				</div>
				<hr />
				<div class="col-md-12" style="padding-top: 20px;">
					<a class="btn-link" role="button" data-toggle="collapse" href="#historyCollapse" aria-expanded="false" aria-controls="historyCollapse">
					  <legend><strong class="text-primary">Penalty</strong></legend>
					</a>
					<div class="collapse" id="historyCollapse">
					    <a href="#" class="list-group-item">
					      <h4 class="list-group-item-heading"><p class="text-warning"></p></h4>
							  <p class="list-group-item-text"></p>
							  <p class="list-group-item-text"></p>
					    </a>
					    <a href="#" class="list-group-item">
					      <h4 class="list-group-item-heading"><p class="text-success"></p></h4>
							  <p class="list-group-item-text"></p>
							  <p class="list-group-item-text">
							 		 <p class="list-group-item-text"></p>
					    </a>
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
	$(document).ready(function(){
		$('#page-body').show(400);
		@if( Session::has("success-message") )
		  swal("Success!","{{ Session::pull('success-message') }}","success");
		@endif
		@if( Session::has("error-message") )
		  swal("Oops...","{{ Session::pull('error-message') }}","error");
		@endif
	});
</script>
@stop
