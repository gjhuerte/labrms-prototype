@extends('layouts.master-white')
@section('title')
Accounts
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
<style>
  #page-body{
    display:none;
  }
  .panel{
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
  }
</style>
@stop
@section('content')
<div class="container-fluid" id="page-body">
  @include('account.sidebar.default')
  <div class="col-md-7">
    <div class="panel panel-body" style="padding: 35px;">  
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
        <legend><h3 style="color:#337ab7;"> Account Update </h3></legend>
      </div>
      <div class="col-md-12">
          {{ Form::model($user,array('route'=>array('account.update',$user->id),'method'=>'PUT',
            'class' => 'form-horizontal'
          )) }}
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
            {{ Form::label('type','Role') }}
            {{ Form::select('type',[
              'assistant'=>'Laboratory Assistant',
              'staff'=>'Staff',
              'faculty'=>'Faculty',
              'student'=>'Student'
            ],Input::old('type'),[
              'class'=>'form-control'
            ]) }}
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-12">
            {{  Form::submit('Update',[
              'class' => 'btn btn-lg btn-primary btn-block'
            ]) }}
            </div>
          </div>
        {{ Form::close() }}
      </div>
    </div><!-- Row -->
  </div>
  <div class="col-md-3">
    <div class="panel panel-primary" style="border: none;border-radius: 0px;">
      <div class="panel-heading">
      Password Reset
      </div>
      <div class="panel-body" style="padding: 20px;">
        <p class="text-muted text-justify" style="letter-spacing: 2px;"> By clicking the button below resets the account password to the default <strong>123456</strong>.
        </p>
        <button class="btn btn-sm btn-danger btn-block" id="reset">Reset</button>
      </div>
    </div>
  </div>
</div><!-- Container -->
@stop
@section('script')
<script type="text/javascript">
  $(document).ready(function(){
    $('#reset').click(function(){
      swal({
        title: "Password Change Confirmation",
        text: "This will change the users password to default 123456. Do you want to continue",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: false,
        closeOnCancel: false,
        showLoaderOnConfirm: true,
      },
      function(isConfirm){
        if(isConfirm){
          $.ajax({
            type: 'post',
            url: '{{ url('/changeUserPassword') }}',
            data: {'id' : {{ $user->id }}},
            before: function(){
              setTimeout(swal("Sending Data..."),5000);
            }, 
            success: function(response){ 
              swal("Operation Success","Password change back to the default 123456","success");
            },
            error: function(response){
              swal("Error","Error encountered while changing the password","error");
            }
          });
        } else{
          swal("Cancelled","Operation Cancelled","error")
        }
      });
    });
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