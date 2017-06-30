@extends('layouts.master-blue')
@section('title')
Assign
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
        <legend><h3 style="color:#337ab7;">Deployment</h3></legend>
        {{ Form::open(array('method'=>'put','route'=>array('inventory.room.update'),'class' => 'form-horizontal')) }}
        <div class="form-group">
          <div class="col-md-12">
            {{ Form::label('item','Wokstation for transfer') }}
            {{ Form::text('item',Input::get('item'),[
              'class'=>'form-control',
              'id'=>'item',
              'placeholder'=>'Wokstation for transfer',
              'readonly'
            ]) }}
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12">
            {{ Form::label('room','Room Name') }}
            <select name='room' class='form-control'>
             @if(!empty(Room::all()))
              @foreach(Room::all() as $room)
                  <option value='{{ $room->id }}'>{{ $room->name }}</option>
              @endforeach
             @endif
            </select>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12">
            {{ Form::submit('Transfer',[
              'class'=>'btn btn-md btn-primary btn-block',
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
  @if( count( $roominventory ) > 0 )
    $('#item').text('item');
  @endif
  @if( Session::has("success-message") )
      swal("Success!","{{ Session::pull('success-message') }}","success");
  @endif
  @if( Session::has("error-message") )
      swal("Oops...","{{ Session::pull('error-message') }}","error");
  @endif
</script>
@stop