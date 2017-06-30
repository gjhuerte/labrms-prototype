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
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
<style>
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
           {{ Form::label('room','Room') }}
           {{ Form::select('room',['Loading all rooms...'],Input::old('room'),[
            'id' => 'room',
            'class' => 'form-control'
           ]) }}
          </div>
        </div>
        <div class="col-sm-12">
          <div class="form-group">
          {{  Form::submit('Assign',[
            'class' => 'btn btn-lg btn-primary btn-block'
          ]) }}
          </div>
        </div>
      {{ Form::close() }}
    </div>
  </div>
</div><!-- Container -->
@stop
@section('script')
<script type="text/javascript">
  $(document).ready(function(){

    //initialize fields
    init();
    //messages
    @if( Session::has("success-message") )
      swal("Success!","{{ Session::pull('success-message') }}","success");
    @endif
    @if( Session::has("error-message") )
      swal("Oops...","{{ Session::pull('error-message') }}","error");
    @endif


    //append to selectbox
    function setSelectBox(item,selectbox)
    {
      $(selectbox).html("");
      $(selectbox).append(item);
    }

    //set select box item
    function setSelectBoxItem(item,value,text)
    {
      item += `<option value="`+value+`">`+text+`</option>`;
      return item;
    }

    //init ...
    function init(){
      setItemType();
      setRooms();
    }

    //initialize item type
    function setItemType(){
      $.ajax({
          type:'get',
          url:'{{ url("get/item/type/all") }}',
          data: {
            'workstation': 'workstation'
          },
          dataType:'json',
          success:function(response){
            var item = "";
            for(ctr = 0;ctr < response.length;ctr++)
            {
              item = setSelectBoxItem(item,response[ctr].id,response[ctr].name);
            }

            if(response.length == 0){
              item = setSelectBoxItem(item,'No record found','No record found');
            }

            setSelectBox(item,'#itemtype');
            setBrand();
          }
      });
    }

    $('#itemtype').on('change',function(){
      setBrand();
    });

    function setBrand()
    {
      $.ajax({
        type: 'get',
        url: '{{  url("get/item/brand/all")  }}',
        data: {
          'itemtype': $('#itemtype').val()
        },
        dataType: 'json',
        success:function(response){
          var item = "";
          for(ctr = 0;ctr < response.length;ctr++)
          {
            item = setSelectBoxItem(item,response[ctr].brand,response[ctr].brand);
          }

          if(response.length == 0){
            item = setSelectBoxItem(item,'No record found','No record found');
          }

          setSelectBox(item,'#brand');
        },
        complete: function(){
          setModel();
        }
      })
    }

    $('#brand').bind('change',function(){
      setModel();
    });

    function setModel()
    {
      $.ajax({
        type: 'get',
        url: '{{  url("get/item/model/all")  }}',
        data: {
          'brand': $('#brand').val()
        },
        dataType: 'json',
        success:function(response){
          var item = "";
          for(ctr = 0;ctr < response.length;ctr++)
          {
            item = setSelectBoxItem(item,response[ctr].model,response[ctr].model);
          }

          if(response.length == 0){
            item = setSelectBoxItem(item,'No record found','No record found');
          }

          setSelectBox(item,'#model');
        },
        complete: function(){
          setPropertyNumber();
        }
      })
    }

    $('#model').bind('change',function(){
      setPropertyNumber();
    });

    function setPropertyNumber()
    {
      $.ajax({
        type: 'get',
        url: '{{  url("get/item/propertynumber/server")  }}',
        data: {
          'model': $('#model').val(),
          'brand': $('#brand').val(),
          'itemtype': $('#itemtype').val()
        },
        dataType: 'json',
        success:function(response){
          var item = "";
          for(ctr = 0;ctr < response.length;ctr++)
          {
            item = setSelectBoxItem(item,response[ctr].propertynumber,response[ctr].propertynumber);
          }

          if(response.length == 0){
            item = setSelectBoxItem(item,'No record found','No record found');
          }

          setSelectBox(item,'#propertynumber');
        }
      });
    }

    //room selectbox
    function setRooms(){
      $.ajax({
        type:'get',
        url:'{{ url("room") }}',
        dataType:'json',
        success:function(response){
          var item = "";
          for(ctr = 0;ctr<response.length;ctr++)
          {
            item = setSelectBoxItem(item,response[ctr].id,response[ctr].name);
          }

          if(response.length == 0){
            item = setSelectBoxItem(item,'No record found','empty');
          }

          setSelectBox(item,'#room');
          $('#room').val('7');
        }
      });
    }

    $('#page-body').show();
  });
</script>
@stop
