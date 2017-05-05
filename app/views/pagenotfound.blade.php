@extends('layouts.master-plain')
@section('title')
Page Not Found
@stop
@section('style')
<style>
  #page-body{
    display: none;
  }
</style>
@stop
@section('content')
<div class="container-fluid" id="page-body">
  <div class="col-md-12" style="padding-top: 50px;">
    <img src="{{ asset('images/logo/ccis/ccis-logo-64.png') }}" class="img img-responsive center-block">
    <h1 class="text-muted text-center">The page you requested does not exists</h1>
    <div class="col-md-offset-4 col-md-4" style="padding:0px 10px 0px 10px">
      <button class="btn btn-lg btn-default btn-block" id="redirect"><span class="glyphicon glyphicon-share-alt"></span> <span class="hidden-xs">Return to safety</span></button>
    </div>
  </div>  
</div><!-- Container -->
<nav class="navbar navbar-default navbar-fixed-bottom">
  <div class="col-md-12">
    <p class="text-muted text-center" style="padding: 20px;margin: 20px;">CCIS - LOO &copy; 2017</p>
  </div>
</nav>
@stop
@section('script')
<script>
  $(document).ready(function(){
    $('#page-body').show();
    $('#redirect').click(function(){
      window.location.href = "{{ url('dashboard') }}";
    });
  });
</script>
@stop