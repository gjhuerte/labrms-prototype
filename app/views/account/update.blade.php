@extends('layouts.master-white')
@section('title')
Accounts
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
<style>
  #page-body{
    display:none;
  }
</style>
@stop
@section('content')
<div class="container-fluid" id="page-body">
  <div class="col-md-offset-3 col-md-6">
    <div class="panel panel-body panel-shadow" style="padding: 35px;">
        @if (count($errors) > 0)
           <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <ul class="list-unstyled" style='margin-left: 10px;'>
                    @foreach ($errors->all() as $error)
                        <li class="text-capitalize">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
      <div class='col-md-12'>
  			<ol class="breadcrumb">
  			  <li><a href="{{ url('account') }}">Account</a></li>
    			  <li><a href="{{ url('account/view/update') }}">Update</a></li>
  			  <li class="active">{{ $user->id }}</li>
  			</ol>
      </div>
      <div class="col-md-12">
          {{ Form::model($user,array('route'=>array('account.update',$user->id),'method'=>'PUT',
            'class' => 'form-horizontal',
            'id' => 'updateForm'
          )) }}
          <div class="form-group">
            <div class="col-md-12">
            {{ Form::label('username','Username') }}
            {{ Form::text('username',Input::old('username'),[
                'class' => 'form-control',
                'id' => 'username',
                'placeholder' => 'Username'
            ])}}
            <p class="text-muted" style="font-size: 10px;"><span class="text-success">Note:</span>The Identification Number will be used as the username of the said person.</p>
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-12">
            {{ Form::label('firstname','Firstname') }}
            {{ Form::text('firstname',Input::old('firstname'),[
                'class' => 'form-control',
                'id' => 'firstname',
                'placeholder' => 'First name'
              ]) }}
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-12">
            {{ Form::label('middlename','Middlename') }}
            {{  Form::text('middlename',Input::old('middlename'),[
                  'class' => 'form-control',
                  'id' => 'middlename',
                  'placeholder' => 'Middle name'
                ])}}
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-12">
            {{ Form::label('lastname','Lastname') }}
             {{ Form::text('lastname',Input::old('lastname'),[
                'class' => 'form-control',
                'id' => 'lastname',
                'placeholder' => 'Last name'
             ]) }}
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-12">
            {{ Form::label('contactnumber','Mobile Number') }}
            {{ Form::text('contactnumber',Input::old('contactnumber'),[
                'class' => 'form-control',
                'id' => 'contactnumber',
                'placeholder' => 'Mobile Number'
            ]) }}
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-12">
            {{ Form::label('email','Email') }}
            {{ Form::text('email',Input::old('email'),[
                'class' => 'form-control',
                'id' => 'email',
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
  <div class="col-md-3" id="password-reset">
    <div class="panel panel-default" style="border: none;border-radius: 0px;">
      <div class="panel-heading">
      Password Reset <span type="button" id="hide" class="pull-right glyphicon glyphicon-remove-sign"></span>
      </div>
      <div class="panel-body" style="padding: 20px;">
        <p class="text-muted text-justify" style="letter-spacing: 2px;"> By clicking the button below resets the account password to the default <strong>12345678</strong>.
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

    $( "#updateForm" ).validate( {
      rules: {
        firstname: "required",
        lastname: "required",
        username: {
          required: true,
          minlength: 4
        },
        contactnumber: {
          required: true,
          minlength: 11,
          maxlength: 11
        },
        email: {
          required: true,
          email: true
        }
      },
      messages: {
        firstname: "Please enter your firstname",
        lastname: "Please enter your lastname",
        username: {
          required: "Please enter a username",
          minlength: "Your username must consist of at least 4 characters"
        },
        contactnumber: {
          required: "Please provide your contact number",
          minlength: "Contact Number must be 11-digit",
          minlength: "Contact Number must be 11-digit"
        },
        email: "Please enter a valid email address"
      },
      errorElement: "em",
      errorPlacement: function ( error, element ) {
        // Add the `help-block` class to the error element
        error.addClass( "help-block" );

        // Add `has-feedback` class to the parent div.form-group
        // in order to add icons to inputs
        element.parents( ".form-group" ).addClass( "has-feedback" );

        if ( element.prop( "type" ) === "checkbox" ) {
          error.insertAfter( element.parent( "label" ) );
        } else {
          error.insertAfter( element );
        }

        // Add the span element, if doesn't exists, and apply the icon classes to it.
        if ( !element.next( "span" )[ 0 ] ) {
          $( "<span class='glyphicon glyphicon-remove form-control-feedback'></span>" ).insertAfter( element );
        }
      },
      success: function ( label, element ) {
        // Add the span element, if doesn't exists, and apply the icon classes to it.
        if ( !$( element ).next( "span" )[ 0 ] ) {
          $( "<span class='glyphicon glyphicon-ok form-control-feedback'></span>" ).insertAfter( $( element ) );
        }
      },
      submitHandler: function(form) {
        // do other things for a valid form
        swal({
          title: "Are you sure?",
          text: "Account will be updated.",
          type: "warning",
          showCancelButton: true,
          confirmButtonText: "Yes, submit it!",
          cancelButtonText: "No, cancel it!",
          closeOnConfirm: false,
          closeOnCancel: false
        },
        function(isConfirm){
          if (isConfirm) {
            form.submit();
          } else {
            swal("Cancelled", "Registration Cancelled", "error");
          }
        })
      },
      highlight: function ( element, errorClass, validClass ) {
        $( element ).parents( ".form-group" ).addClass( "has-error" ).removeClass( "has-success" );
        $( element ).next( "span" ).addClass( "glyphicon-remove" ).removeClass( "glyphicon-ok" );
      },
      unhighlight: function ( element, errorClass, validClass ) {
        $( element ).parents( ".form-group" ).addClass( "has-success" ).removeClass( "has-error" );
        $( element ).next( "span" ).addClass( "glyphicon-ok" ).removeClass( "glyphicon-remove" );
      }
    } );

    $('#hide').click(function(){
      $('#password-reset').hide();
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
@section('script-include')
<script type="text/javascript" src="{{ asset('js/jquery.validate.min.js') }}"></script>
@stop
