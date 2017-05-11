@extends('layouts.master-white')
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
	<h1 class="text-center text-muted">No Profile to show</h1>
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
