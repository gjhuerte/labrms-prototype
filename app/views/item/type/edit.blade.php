@extends('layouts.master-blue')
@section('title')
Update
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('content')
<div class="container-fluid">
    @include('item.type.sidebar.default')
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
      <div class="col-md-12 panel panel-body" style="padding: 25px;padding-top: 10px;">
        <legend><h3 style="color:#337ab7;">Item type</h3></legend>
        {{ Form::model($itemtype,array(
              'route'=>['item.type.update',$itemtype->id],
              'method'=>'PUT',
              'class' => 'form-horizontal'
        )) }}
        <div class="form-group">
          <div class="col-md-12">
            {{ Form::label('type','Item Type Name') }}
            {{ Form::text('type',Input::old('type'),[
              'required',
              'class'=>'form-control',
              'placeholder'=>'Item name'
            ]) }}
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12">
            {{ Form::label('description','Description') }}
            {{ Form::textarea('description',Input::old('description'),[
              'required',
              'class'=>'form-control',
              'placeholder'=>'Description'
            ]) }}
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-12">
            {{ Form::submit('Update',[
              'class'=>'btn btn-md btn-primary col-sm-offset-4 col-sm-4'
            ]) }}
            {{ Form::button('Cancel',[
              'class'=>'btn btn-md btn-info col-sm-4',
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
  $(document).ready(function(){
    $('#cancel').click(function(){
      window.location.replace('{{ url('item/type') }}');
    });
    @if( Session::has("success-message") )
        swal("Success!","{{ Session::pull('success-message') }}","success");
    @endif
    @if( Session::has("error-message") )
        swal("Oops...","{{ Session::pull('error-message') }}","error");
    @endif
  });
</script>
@stop