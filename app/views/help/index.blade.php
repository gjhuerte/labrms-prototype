@extends('layouts.master-plain')
@section('title')
Help
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
<link rel="stylesheet" href="{{ asset('css/style.css') }}"  />
<style>
  #page-body{
    display: none;
  }

  body {
  	background-color: #e5e5e5;
  }
</style>
@stop
@section('script-include')
<script type="text/javascript" src="{{ asset('js/jquery.validate.min.js') }}"></script>
@stop
@section('content')
<div class="row">
	<div class="col-md-4">
		<div class="visible-xs" style="margin: 10px 0px;">
			<button class="btn btn-primary"><span class="glyphicon glyphicon-th-list"></span> Navigation</button>
		</div>
		<div class="panel panel-default hidden-xs">
			<ul class="list-group">
				<li class="list-group-item">
					Item  1
				</li>
				<li class="list-group-item">
					Item 2
				</li>
			</ul>
		</div>
	</div>
	<div class="col-md-8 content">
		<div class="panel panel-default">
			<div class="panel-heading">
				Item Question
			</div>
			<div class="panel-body">
				<p class="text-center text-muted">
					Content
				</p>
			</div>
		</div>
	</div>
</div>
@stop
@section('script')
@stop
