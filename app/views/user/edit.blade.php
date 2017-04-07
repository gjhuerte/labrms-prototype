@extends('layouts.master-blue')
@section('title')
Change Password
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('content')
<div class="container-fluid" id='page-body' hidden>
  <div class="col-md-offset-3 col-md-6">
    <div class="panel panel-body" style="padding: 20px;"> 
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
      <div class='col-sm-12'>
        <legend><h3 style="color:#337ab7;"> Account Update </h3></legend>
      </div>
      {{ Form::open(['method'=>'POST','route'=>'settings.update']) }}
      <div class="col-sm-12">
       <div class="form-group">
        {{ Form::label('password','Current Password') }}  
        {{ Form::text('password',Input::old('password'),[
            'class' => 'form-control',
            'placeholder' => 'Current Password'
          ]) }}
        </div>
      </div>
      <div class="col-sm-12">
       <div class="form-group">
        {{ Form::label('newpassword','New Password') }}  
        {{ Form::text('newpassword',Input::old('newpassword'),[
            'class' => 'form-control',
            'placeholder' => 'New Password'
          ]) }}
        </div>
      </div>
      <div class="col-sm-12">
        <div class="form-group">
        {{  Form::submit('Update',[
          'class' => 'btn btn-md btn-primary btn-block'
        ]) }}
        </div>
      </div>
    {{ Form::close() }}
  </div><!-- Row -->
</div><!-- Container -->
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