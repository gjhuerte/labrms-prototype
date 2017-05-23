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
  #page-body,#other-page{
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
      <div class="col-md-12">
        <div class="pull-right">
          <div class="btn-group btn-group-xs">
            <div class="btn-group">
              <button class="btn btn-md btn-primary" id="pc">PC</button>
            </div>
            <div class="btn-group">
              <button class="btn btn-md btn-default" id="other">Other</button>
            </div>
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
      {{ Form::open(['method'=>'POST','route'=>'inventory.room.assign.store','id'=>'registrationForm']) }}
      <div id="pc-page">
        <div class="col-sm-12">
         <div class="form-group">
           {{ Form::label('workstation','Workstation') }}
           <table class="table table-hover table-condensed table-bordered">
             <thead>
               <th>Checkbox</th>
               <th>System Unit</th>
               <th>Monitor</th>
               <th>AVR</th>
               <th>Keyboard</th>
               <th>Mouse</th>
             </thead>
             <tbody id="pc-body">
             </tbody>
           </table>
          </div>
        </div>
      </div>
      <div id="other-page">
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
  </div><!-- Row -->
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

    $('#pc').click(function(){
      setButton('#pc','btn-default','btn-primary');
      setButton('#other','btn-primary','btn-default');
      setObject('#other-page','#pc-page');
    });

    $('#other').click(function(){
      setButton('#other','btn-default','btn-primary');
      setButton('#pc','btn-primary','btn-default');
      setObject('#pc-page','#other-page');
    })

    function setButton(object,oldClass,newClass)
    {
      $(object).removeClass(oldClass);
      $(object).addClass(newClass);
    }

    function setObject(hideObject,showObject)
    {
      $(hideObject).hide(400);
      $(showObject).show(400);
    }


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
      setWorkstationBody();
      setItemType();
      setTimeout(setBrand,1000);
      setTimeout(setModel,2000);
      setTimeout(setPropertyNumber,3000);
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
          }
      });
    }

    //initialize brand
    function setBrand(){
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
        }
      })
    }

    //intialize model..
    function setModel(){
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
        }
      })
    }

    //initialize property number
    function setPropertyNumber(){
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
      })
    }

    $('#itemtype').change(function(){
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
        }
      })
    });

    $('#brand').change(function(){
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
        }
      })
    });

    $('#model').change(function(){
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
    });

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

    function setWorkstationBody()
    {
      $.ajax({
        type: 'get',
        url: "{{ url('get/workstation/tableform/all') }}",
        dataType: 'html',
        success: function(response){
          $('#pc-body').html("");
          $('#pc-body').append(response);
        },
      })
    }

    $('#page-body').show();
  });
</script>
@stop
