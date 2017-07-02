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
	});
</script>
@stop