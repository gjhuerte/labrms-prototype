@extends('layouts.master-blue')
@section('title')
Accounts
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('content')
<div class="container-fluid">
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
            {{  Form::submit('Update',[
              'class' => 'btn btn-lg btn-primary btn-block'
            ]) }}
            </div>
          </div>
        {{ Form::close() }}
    </div>
  </div><!-- Row -->
</div><!-- Container -->
@stop
@section('script')
<script type="text/javascript">
  @if( Session::has("success-message") )
    swal("Success!","{{ Session::pull('success-message') }}","success");
  @endif
  @if( Session::has("error-message") )
    swal("Oops...","{{ Session::pull('error-message') }}","error");
  @endif
</script>
@stop