@extends('layouts.master-white')
@section('title')
Create
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
<style>

  .panel-shadow{
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
  }

</style>
@stop
@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-offset-3 col-sm-6">  
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
      <div class="col-md-12 panel panel-body panel-shadow" style="padding: 25px;padding-top: 10px;">
        <legend><h3 style="color:#337ab7;">Room Creation Form</h3></legend>
        {{ Form::open(array('method'=>'post','route'=>'room.store','class' => 'form-horizontal')) }}
        <div class="form-group">
          <div class="col-md-12">
            {{ Form::label('name','Room Name') }}
            {{ Form::text('name',Input::old('name'),[
              'required',
              'class'=>'form-control',
              'placeholder'=>'Room Name'
            ]) }}
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12">
            {{ Form::label('description','Description') }}
            {{ Form::textarea('description',Input::old('description'),[
              'required',
              'class'=>'form-control',
              'placeholder'=>'Room Description'
            ]) }}
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-offset-4 col-md-4">
            {{ Form::submit('Create',[
              'class'=>'btn btn-primary btn-block',
              'name' => 'create'
            ]) }}
          </div>
          <div class="col-md-4">
            {{ Form::submit('Cancel',[
              'class'=>'btn btn-info btn-block',
              'name' => 'cancel',
              'id' => 'cancel'
            ]) }}
          </div>
        </div>
      {{ Form::close() }}
      </div>
    </div> <!-- centered  -->
  </div><!-- Row -->
</div><!-- Container -->
@stop
@section('script')
<script>
  @if( Session::has("success-message") )
      swal("Success!","{{ Session::pull('success-message') }}","success");
  @endif
  @if( Session::has("error-message") )
      swal("Oops...","{{ Session::pull('error-message') }}","error");
  @endif

  $('#cancel').click(function(){
    window.location.href = "{{ URL::to('room') }}";
  });
</script>
@stop