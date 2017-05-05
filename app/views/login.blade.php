@extends('layouts.master-white')
@section('title')
Login
@stop
@section('navbar')
@include('layouts.navbar.main.default')
@stop
@section('style')
<style>
  .panel{
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
  }
  #return{
    text-decoration: none;
  }

  #return.hover{
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
  }

  a{
    text-decoration: none;
    display: block;
  }

  #page-body{
    display: none;
  }
</style>
@stop
@section('content')
<div class="container-fluid" id="page-body">
  <div class="row">
    <div class="col-sm-offset-3 col-sm-6 col-md-offset-4 col-md-4" style="margin-top: 20px;">  
      <div class="col-sm-12">
        <div class="clearfix"></div>
        <div class="panel panel-body" style="padding: 40px;" id="loginPanel">
        @if (count($errors) > 0)
            <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <ul style='margin-left: 10px;'>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif    
          <div class="col-sm-12 center-block" style="padding:0px;margin-bottom: 10px;padding-bottom: 10px;">
            <div class="col-sm-4">
              <img src="{{ asset('images/logo/ccis/ccis-logo-128.png') }}" class="img-responsive img-circle">
            </div>
            <div class="col-sm-8 center-block text-center">
              <h3 class="text-muted">CCIS - LOO</h3>
              <h6 class="text-muted"><strong>L</strong>aboratory <strong>O</strong>peration <strong>O</strong>ffice</h6>
            </div>
          </div>
          <legend class="clearfix"></legend>
          <!-- <legend><h3 class="text-center text-primary">Log In</h3></legend> -->
            <div style="margin-top: 40px;">
            {{ Form::open(array('class' => 'form-horizontal','id'=>'loginForm')) }}
            <div class="form-group">
              <div class="col-md-12">
                {{ Form::label('username','Username') }}
                {{ Form::text('username',Input::old('username'),[
                  'required',
                  'id'=>'username',
                  'class'=>'form-control',
                  'placeholder'=>'Username',
                  'id' => 'username'
                ]) }}
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12">
              {{ Form::label('Password') }}
              {{ Form::password('password',[
                  'required',
                  'id'=>'password',
                  'class'=>'form-control',
                  'placeholder'=>'Password',
              ]) }}
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12">
                  <button type="submit" id="loginButton" data-loading-text="Logging in..." class="btn btn-md btn-primary btn-block" autocomplete="off">
                  Login
                </button>
              </div>
            </div>
            <a class="text-center text-muted" type="button" role="button" style="text-decoration: none;"><small style="letter-spacing: 2px;">Forgot your password?</small></a>
          {{ Form::close() }}
          </div>
        </div>
      </div>
    </div> <!-- centered  -->
  </div><!-- Row -->
</div><!-- Container -->
@stop
@section('script')
<script>
  $(document).ready(function(){
    $('#page-body').show();

    @if( Session::has("success-message") )
        swal("Success!","{{ Session::pull('success-message') }}","success");
    @endif

    @if( Session::has("error-message") )
        swal("Oops...","{{ Session::pull('error-message') }}","error");
    @endif
  
    $('#loginButton').submit(function(){
      return false;
    });

    $('#loginButton').on('click', function () {
      var $btn = $(this).button('loading')
      $('#loginForm').submit();
    })
  });
</script>
@stop