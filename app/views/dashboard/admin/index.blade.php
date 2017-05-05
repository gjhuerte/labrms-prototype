@extends('layouts.master-blue')
@section('title')
Dashboard
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
<style>
  .panel-shadow{
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
  }
</style>
@stop
@section('content')
<div class="container-fluid">
	<div class="col-md-3">
		<ul class="list-group panel panel-default">
			<div class="panel-heading">
			    Notification  <span class="label label-primary" id="notification-count" val=0>0</span> <p class="text-success pull-right">Active</p> 
			</div>
			<li class="list-group-item">
			List Item
			</li>
		</ul>
	</div>
	<div class="col-md-6">
		<ul class="list-group panel panel-default">
			<div class="panel-body" id="content">
				<p class="text-muted pull-right" id="date"></p>
			</div>
		</ul>
	</div>
	<div class="col-md-3">
		<button class="btn btn-default btn-block"><span class="glyphicon glyphicon-book"></span> Generate Ticket</button>
	</div>
</div>
@stop
@section('script')
<script type="text/javascript">
	$(document).ready(function() {
		@if( Session::has("success-message") )
		  swal("Success!","{{ Session::pull('success-message') }}","success");
		@endif
		@if( Session::has("error-message") )
		  swal("Oops...","{{ Session::pull('error-message') }}","error");
		@endif
		setInterval(function(){
			var count = $('#notification-count').val();
			count++;
			$('#notification-count').val(count);
			$('#notification-count').html(count);
		},1000);
	});
</script>
@stop