@extends('layouts.master-blue')
@section('title')
Create
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('content')
<div class="container-fluid" id="page-body" hidden>
  @include('account.sidebar.create')
  <div class="col-sm-8">
    <div class="panel panel-body"> 
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
      <div class='col-md-12'>
        <legend><h3 style="color:#337ab7;"> Account Creation Form </h3></legend>
      </div>
      <div class="col-md-12">
        {{ Form::open(['class' => 'form-horizontal','id'=>'registrationForm','route'=>'account.store']) }}
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
        {{ Form::close() }}
      </div>
  </div><!-- Row -->
</div><!-- Container -->
@stop
@section('script')
<script>  
  $(document).ready(function(){
    $('#page-body').show(400);

    $('#register').click(function(){
      swal({
        title: "Are you sure?",
        text: "Account information will be added to the database.",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, submit it!",
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
  });
</script>
@stop