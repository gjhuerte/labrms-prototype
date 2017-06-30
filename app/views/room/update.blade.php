@extends('layouts.master-blue')
@section('title')
Update
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
</style>
@stop
@section('content')
<div class="container-fluid" id="page-body">
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
      <div class="col-md-12 panel panel-body " style="padding: 25px;padding-top: 10px;">
        <ol class="breadcrumb">
            <li>
              <a href="{{ url('room') }}">Room</a>
            </li>
            <li>
              <a href="{{ url('room/view/update') }}">Update</a>
            </li>
            <li class="active">
              {{ $room->name }}
            </li>
        </ol>
        {{ Form::model($room,array('route'=>array('room.update',$room->id),'method'=>'PUT',
            'class' => 'form-horizontal'
          )) }}
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
        <div class="col-md-12">
          <div class="form-group">
            {{ Form::submit('Update',[
              'class'=>'btn btn-lg btn-primary btn-block',
              'name' => 'create'
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
  $(document).ready(function(){

    @if( Session::has("success-message") )
        swal("Success!","{{ Session::pull('success-message') }}","success");
    @endif
    @if( Session::has("error-message") )
        swal("Oops...","{{ Session::pull('error-message') }}","error");
    @endif

    $('#cancel').click(function(){
      window.location.href = "{{ URL::to('room') }}";
    });

    $('#page-body').show();
  });
</script>
@stop
