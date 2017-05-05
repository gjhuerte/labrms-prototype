@extends('layouts.master-blue')
@section('title')
Room Assignment
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('script-include')
<script type="text/javascript" src="{{ asset('js/jquery.validate.min.js') }}"></script>
@stop
@section('style')
<style>
  .panel-shadow{
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
  }

  #page-body{
    display: none;
  }
</style>
@stop
@section('content')
<div class="container-fluid" id='page-body'>
  <div class="col-md-offset-3 col-md-6">
    <div class="panel panel-body panel-shadow">
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
      <div class='col-sm-12'>
        <ol class="breadcrumb">
          <li><a href="{{ url('inventory/item') }}">Inventory</a></li>
          <li><a href="{{ url('inventory/room') }}">Room</a></li>
          <li class="active">Assign</li>
        </ol>
      </div>
      {{ Form::open(['method'=>'POST','route'=>'inventory.room.assign.store','id'=>'registrationForm']) }}
      <div class="col-sm-12">
       <div class="form-group">
         {{ Form::label('itemtype','Item type') }}
         {{ Form::select('itemtype',['Loading all types...'],Input::old('itemtype'),[
          'id' => 'itemtype',
          'class' => 'form-control'
         ]) }}
        </div>
      </div>
      <div class="col-sm-12">
       <div class="form-group">
         {{ Form::label('brand','Brand') }}
         {{ Form::select('brand',['Loading all brands...'],Input::old('brand'),[
          'id' => 'brand',
          'class' => 'form-control'
         ]) }}
        </div>
      </div>
      <div class="col-sm-12">
       <div class="form-group">
         {{ Form::label('model','Model') }}
         {{ Form::select('model',['Loading all model...'],Input::old('model'),[
          'id' => 'model',
          'class' => 'form-control'
         ]) }}
        </div>
      </div>
      <div class="col-sm-12">
       <div class="form-group">
         {{ Form::label('propertynumber','Property Number') }}
         {{ Form::select('propertynumber',['Loading all Property Number...'],Input::old('propertynumber'),[
          'id' => 'propertynumber',
          'class' => 'form-control'
         ]) }}
        </div>
      </div>
      <div class="col-sm-12">
       <div class="form-group">
         {{ Form::label('room','Rooms') }}
         {{ Form::select('room',['Loading all rooms...'],Input::old('room'),[
          'id' => 'room',
          'class' => 'form-control'
         ]) }}
        </div>
      </div>
      <div class="col-sm-12">
        <div class="form-group">
        {{  Form::submit('Assign',[
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
