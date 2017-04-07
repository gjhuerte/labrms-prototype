@extends('layouts.master-blue')
@section('title')
Transfer
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('content')
<div class="container-fluid">
  <div class="row">
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
        <legend><h3 style="color:#337ab7;">Transfer / Assignment</h3></legend>
        {{ Form::open(array('method'=>'put','route'=>array('item.profile.update',$item->id),'class' => 'form-horizontal')) }}
        <div class="form-group">
          <div class="col-md-12">
            {{ Form::label('location','Current Location') }}
            {{ Form::text('location',null,[
              'class' => 'form-control',
              'readonly',
              'id' => 'location'
            ]) }}
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12">
            {{ Form::label('newlocation','New Location') }}
            <select name='newlocation' class='form-control'>
             @if(!empty(Room::all()))
              @foreach(Room::all() as $room)
                @if($item->location != $room->name)
                  <option value='{{ $room->name }}'>{{ $room->name }}</option>
                @endif
              @endforeach
             @endif
            </select>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12">
            {{ Form::submit('Transfer',[
              'class'=>'btn btn-lg btn-primary btn-block',
              'name' => 'transfer'
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
  @if(!empty($item))
    $('#location').val('{{ $item->location }}');
  @endif
  @if( Session::has("success-message") )
      swal("Success!","{{ Session::pull('success-message') }}","success");
  @endif
  @if( Session::has("error-message") )
      swal("Oops...","{{ Session::pull('error-message') }}","error");
  @endif
</script>
@stop