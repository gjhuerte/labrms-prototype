@extends('layouts.master-blue')
@section('title')
Register
@stop
@section('navbar')
@include('layouts.navbar.main.default')
@stop
@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-offset-3 col-md-6">    
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
      <div class="panel panel-body">
        <div class='col-md-12'>
          <legend><h3 style="color:#337ab7;"> Register </h3></legend>
        </div>
        <div class="col-md-12">
          {{ Form::open(array('class' => 'form-horizontal','id'=>'registrationForm')) }}
          <div class="form-group">
            <div class="col-md-12">
            {{ Form::label('firstname','Firstname') }}  
            {{ Form::text('firstname',Input::old('firstname'),[
                'class' => 'form-control',
                'placeholder' => 'First name'
              ]) }}
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-12">
            {{ Form::label('middlename','Middlename') }}
            {{  Form::text('middlename',Input::old('middlename'),[
                  'class' => 'form-control',
                  'placeholder' => 'Middle name'
                ])}}
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-12">
            {{ Form::label('lastname','Lastname') }}
             {{ Form::text('lastname',Input::old('lastname'),[
                'class' => 'form-control',
                'placeholder' => 'Last name'
             ]) }}
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-12">
            {{ Form::label('contactnumber','Mobile Number') }}  
            {{ Form::text('contactnumber',Input::old('contactnumber'),[
                'class' => 'form-control',
                'placeholder' => 'Mobile Number'
            ]) }}
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-12">
            {{ Form::label('email','Email') }}  
            {{ Form::text('email',Input::old('email'),[
                'class' => 'form-control',
                'placeholder' => 'Email'
            ]) }}
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-12">
            {{ Form::label('username','Username') }}
            {{ Form::text('username',Input::old('username'),[
                'class' => 'form-control',
                'placeholder' => 'Username'
            ])}}
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-12">
            {{ Form::label('password','Password') }}
            {{ Form::password('password',[
                'class' => 'form-control',
                'placeholder' => 'Password'
            ]) }}
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-12">
            {{ Form::label('confirm','Confirm Password') }}
            {{ Form::password('confirm',[
                'class' => 'form-control',
                'placeholder' => 'Confirm Password'
            ]) }}
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-4">
              <div class="radio-inline">
              {{ Form::radio('type','student',true) }} Student
              </div>
            </div>
            <div class="col-md-4">
              <div class="radio-inline">
              {{ Form::radio('type','faculty') }} Faculty
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-12">
            {{  Form::button('Create',[
              'class' => 'btn btn-lg btn-primary btn-block',
              'id'=>'register'
            ]) }}
            </div>
          </div>
          <div class="col-md-12">
            <div class="col-6-md">
              <p style="font-size:10px; text-align: center;">By registering, you agree to our  Policy & Terms</p>
            </div>
          </div>
          {{ Form::close() }}
        </div>
    </div>
  </div><!-- Row -->
</div><!-- Container -->
@stop
@section('script')
<script>  
  $('#register').click(function(){
    swal({
      title: "Are you sure?",
      text: "Your account information will be submitted to the administation. Present your identification card to activate your account.",
      type: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, i agree!",
      cancelButtonText: "No, cancel it!",
      closeOnConfirm: false,
      closeOnCancel: false
    },
    function(isConfirm){
      if (isConfirm) {
        $("#registrationForm").submit();
      } else {
        swal("Cancelled", "Registration Cancelled", "error");
      }
    });
  });
</script>
@stop