@extends('layouts.master-blue')
@section('title')
Create
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('content')
{{ Form::open(array('class' => 'form-horizontal','method'=>'post','route'=>'item.type.store','id'=>'itemTypeForm')) }}
<div class="container-fluid">
  <div class="row">
    @include('item.type.sidebar.default')
    <div class="col-sm-6">  
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
        <div class="form-group">
          <div class="col-md-12">
            {{ Form::label('name','Item Type Name') }}
            {{ Form::text('name',Input::old('name'),[
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
          <div class="col-sm-offset-4 col-sm-4">
            {{ Form::submit('Submit',[
              'class'=>'btn btn-block btn-md btn-primary'
            ]) }}
          </div>
          <div class="col-sm-4">
            {{ Form::button('Cancel',[
              'class'=>'btn btn-md btn-block btn-info',
              'id' => 'cancel'
            ]) }}
          </div>
        </div>
      </div>
    </div> <!-- centered  -->
    <div class="col-md-4">
      <div class="panel panel-body">
        <div class="col-md-12">
          <legend class="text-muted">Fields</legend>
        </div>
        <div id="fieldList">
          <div class="col-md-12" style="margin-bottom: 10px;" id="field0">
            <div class="form-group">
              <div class="col-md-10">
                <input type="text" class="form-control field-remove" name="form0" placeholder="Field Name">
              </div>
              <div class="col-md-2">
                <button class="btn btn-danger btn-remove" type="button" role="button" id="0"><span class="glyphicon glyphicon-minus" data-id = '0' id="0"></span></button>
              </div>
            </div>  
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <div class="col-md-10">
              <input type="hidden" name='totalFields' id="totalFields" value='1'>
              <button id="add" data-id = '0' class="add btn btn-block btn-success" type="button"><span class="glyphicon glyphicon-plus"></span> Add</button>
            </div>
        </div>
      </div>
    </div>
  </div><!-- Row -->
</div><!-- Container -->
{{ Form::close() }}
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

    $('#submit').click(function(){
      swal({
        title: "Are you sure?",
        text: "This will submit an item type with the following fields.",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, submit it!",
        cancelButtonText: "No, cancel it!",
        closeOnConfirm: false,
        closeOnCancel: false
      },function(confirm){
        if(confirm){
          $('#itemTypeForm').submit();
        }else{
          swal('Cancel','Operation Cancelled','error');
        }
      });
    });

    $('.add').click(function(){
      var data =  $('.add').data('id') + 1;
      $('#fieldList').append(`
          <div class="col-md-12" style="margin-bottom: 10px;" id="field`+data+`">
            <div class="form-group">
              <div class="col-md-10">
                <input type="text" class="form-control field-remove" name="form`+data+`" placeholder="Field Name">
              </div>
              <div class="col-md-2">
                <button class="btn btn-danger btn-remove" type="button" role="button" id="`+data+`"><span class="glyphicon glyphicon-minus" id="`+data+`" data-id="`+data+`"></span></button>
              </div>
            </div>  
          </div>`);

      $('.add').data('id',data);
      $('#totalFields').val(data+1);
    });

    $('#fieldList').on('click','button.btn-remove',function(event){
      if($('div#fieldList').children('div').length > 1)
        $('#field'+event.target.id).remove();
      else
        swal('Error','There must be atleast one (1) field','error');
    });
  });
</script>
@stop