@extends('layouts.master-blue')
@section('title')
Create
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('content')
<div class="container-fluid" id="page-body" hidden>
  @include('faculty.sidebar.default')
  <div class="col-md-7">
    <div class="panel panel-body" style="padding: 20px;padding-left: 40px;padding-right: 40px;"> 
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
        {{ Form::open([
          'class' =>'form-horizontal',
          'id'=>'registrationForm',
          'route'=>'account.store'
        ]) }}
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
          <div class="col-md-4">
            <div class="radio-inline">
            {{ Form::radio('type','staff',true) }} Laboratory Staff
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
    </div>
  </div><!-- Row -->
  <div class="col-md-3">
    <div class="panel panel-primary" style="border: none;border-radius: 0px;">
      <div class="panel-heading">
        Important Notes
      </div>
      <div class="panel-body">
        <dl>
          <dt class="bg-info text-info" style="padding: 10px;margin: 10px;">Priviledges</dt>
          <dd class="text-muted" style="padding: 10px;margin: 10px;">The <abbr title="Laboratory Resource Management System">LabRMS</abbr> considers <strong>five</strong> different roles for users. Each roles has their own specific tasks and priviledges.</dd>
        </dl>
        <dl>
          <dt class="bg-info text-info" style="padding: 10px;margin: 10px;">Roles</dt>
          <dd class="text-muted" style="padding: 10px;margin: 10px;">
            <ul>
              <li class="text-muted text-justify" data-toggle="collapse" data-parent="#accordion" href="#collapseHead" aria-expanded="true" aria-controls="collapseHead">
                <strong>Laboratory Head</strong>:<br />
                <span id="collapseHead" class="panel-collapse collapse out" aria-labelledby="headingOne"> Manage reports and system maintenance. Whenever he/she creates a reservation, automatically cancels other reservation where it falls. The head is the <strong>only</strong> one capable of altering accounts.</span>
              </li>
              <li class="text-muted text-justify" data-toggle="collapse" data-parent="#accordion" href="#collapseAssistant" aria-expanded="true" aria-controls="collapseAssistant">
                <strong>Laboratory Assistant</strong>:<br />
                <span id="collapseAssistant" class="panel-collapse collapse out" aria-labelledby="headingOne"> responsible for all the equipments and rooms under reservation. He/She logs the borrowed item information. The assistant can add accounts and profile each equipment </span>
              </li>
              <li class="text-muted text-justify" data-toggle="collapse" data-parent="#accordion" href="#collapseStaff" aria-expanded="true" aria-controls="collapseStaff">
                <strong>Laboratory Staff</strong>:<br />
                <span id="collapseStaff" class="panel-collapse collapse out" aria-labelledby="headingOne">  Other personnel under the laboratory department. He/She can profile equipments, accepts complaints, and resolve them.  </span>
              </li>
              <li class="text-muted text-justify" data-toggle="collapse" data-parent="#accordion" href="#collapseFaculty" aria-expanded="true" aria-controls="collapseFaculty">
                <strong>Faculty</strong>:<br />
                <span id="collapseFaculty" class="panel-collapse collapse out" aria-labelledby="headingOne"> Can complain and has responsibility for reserved items</span>
              </li>
              <li class="text-muted text-justify" data-toggle="collapse" data-parent="#accordion" href="#collapseStudent" aria-expanded="true" aria-controls="collapseStudent">
                <strong>Student</strong>:<br />
                <span id="collapseStudent" class="panel-collapse collapse out" aria-labelledby="headingOne"> Consists of class president ( or any other representative for a class ). He / She can reserve specific items under the jurisdiction of the professor in-charge</span>
              </li>
            </ul>
          </dd>
        </dl>
        <dl>
          <dt class="bg-info text-info" style="padding: 10px;margin: 10px;">Mobile Number and Email</dt>
          <dd class="text-muted" style="padding: 10px;margin: 10px;">Each account must have a contact information in case of emergencies</dd>
        </dl>
        <dl>
          <dt class="bg-info text-info" style="padding: 10px;margin: 10px;">Username</dt>
          <dd class="text-muted" style="padding: 10px;margin: 10px;"> The suggested username of an account is its <abbr title="Polytechnic University of the Philippines">PUP</abbr> student ID</dd>
        </dl>
        <dl>
          <dt class="bg-info text-info" style="padding: 10px;margin: 10px;">Password and Confirmation</dt>
          <dd class="text-muted" style="padding: 10px;margin: 10px;">Suggested default password is <strong>123456</strong>. But you can choose different password. <storng>Note:</storng> Password is encrypted so there is no way to view the password. If forgotten, resetting the password is the only solution.</dd>
        </dl>
      </div>
    </div>
  </div>
</div><!-- Container -->
@stop
@section('script')
<script>  
  $(document).ready(function(){
    $('#page-body').show();

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