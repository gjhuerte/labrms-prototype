@extends('layouts.master-white')
@section('title')
Assign
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
@endsection
@section('content')
<div class="container-fluid">
  <div class="col-md-12" id="software-info">
    <div class="col-sm-offset-3 col-sm-6 col-md-offset-4 col-md-4">
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
      <div class="col-md-12 panel panel-body" style="padding: 25px;padding-top: 10px;">
        <ol class="breadcrumb">
          <li><a href="{{ url('software') }}">Software</a></li>
          <li class="active">Assign</li>
        </ol>
        {{ Form::open(array('method'=>'put','route'=>array('software.update'),'class' => 'form-horizontal')) }}
        <div class="form-group">
          <div class="col-md-12">
            {{ Form::label('software','Available software') }}
            {{ Form::text('software',$software->name,[
              'class'=>'form-control',
              'readonly'
            ]) }}
            <input type="hidden" value="{{ $software->id }}" name="software">
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12">
            {{ Form::label('room','Room Name') }}
            {{ Form::select('room',$room,Input::old('room'),[
              'id' => 'room',
              'class'=>'form-control'
            ]) }}
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12">
            {{ Form::label('workstation','Workstation') }}
            {{ Form::select('workstation',['Empty list'=>'Empty list'],Input::old('workstation'),[
              'id' => 'workstation',
              'class'=>'form-control'
            ]) }}
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12">
            {{ Form::submit('Assign',[
              'class'=>'btn btn-md btn-primary btn-block',
              'name' => 'assign'
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
  $('#room').change(function(){
    workStationAjaxRequest();
  });

  $(document).ready(function(){
    workStationAjaxRequest();
  });

  function workStationAjaxRequest(){
    var room = $('#room').val();
    $.ajax({
      type: 'post',
      url: '{{ url('/getAllWorkstation') }}',
      data: {'room' : room},
      dataType: 'json',
      success: function(response){
      options = "";
      if(!$.trim(response))
      {
          options = "<option>Empty list</option>";

      }else{
          for(var ctr = 0;ctr<response.length;ctr++){
            if(response.length > 0)
            {
                options += "<option value='"+response[ctr].id+"'>"+response[ctr].name+"</option>";
            }else{
              options = "<option>Empty list</option>";
            }
          }
      }
        $('#workstation').html(" ");
        $('#workstation').append(options);
      },
      error: function(response){
      console.log(response.responseJSON);
      }
    });
  }

  @if( Session::has("success-message") )
      swal("Success!","{{ Session::pull('success-message') }}","success");
  @endif
  @if( Session::has("error-message") )
      swal("Oops...","{{ Session::pull('error-message') }}","error");
  @endif
</script>
@stop
