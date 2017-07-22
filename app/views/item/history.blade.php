@extends('layouts.master-blue')
@section('title')
Item History
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
<style>
  #page-body{
    display: none;
  }
  .form-control{
    border: none;
  }
</style>
@stop
@section('content')
@stop
@section('script')
<script>
  $(document).ready(function(){
    @if( Session::has("success-message") )
      swal("Success!","{{ Session::pull('success-message') }}","success");
    @endif
    @if( Session::has("error-message") )
      swal("Oops...","{{ Session::pull('error-message') }}","error");
    @endif

    $('#page-body').show()
  })
</script>
@stop
