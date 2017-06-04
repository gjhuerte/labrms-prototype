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
  #page-two,#page-body{
    display: none;
  }
</style>
@endsection
@section('content')
{{ Form::open(['class' => 'form-horizontal','method'=>'put','route'=>array('item.type.update',$itemtype->id),'id'=>'itemTypeForm']) }}
<div class="container-fluid" id="page-body">
  <div class="row">
    <div class="col-md-offset-3 col-md-6">
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
      <div class="panel panel-body ">
        <div id="page-one">
          <ol class="breadcrumb">
              <li>
                  <a href="{{ url('item/type') }}">Type</a>
              </li>
              <li>
                <a href="{{ url('item/type/view/update') }}">Update</a>
              </li>
              <li class="active">{{ $itemtype->id }}</li>
          </ol>
          <div class="form-group">
            <div class="col-md-12">
              {{ Form::label('name','Type') }}
              {{ Form::text('name',Input::old('name'),[
                'id' => 'name',
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
                'id' => 'description',
                'required',
                'class'=>'form-control',
                'placeholder'=>'Description'
              ]) }}
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-8 col-sm-4">
              <button id="next" class="btn btn-block btn-flat btn-md btn-primary" type="button">
                <span class="glyphicon glyphicon-share-alt"></span> <span class="hidden-xs">Next</span>
              </button>
            </div>
          </div>
        </div> <!-- end of page one -->
        <div id="page-two"> <!-- page two -->
          <div class="col-md-12">
            <legend class="text-muted">Fields</legend>
          </div>
          <div id="fieldList">
            <div class="col-xs-12" id="field0">
              <div class="form-group col-md-12">
                <div class="input-group">
                  <input type="text" id="initField" class="form-control field-remove" name="form0" placeholder="Field Name">
                  <span class="input-group-btn">
                    <button class="btn btn-danger btn-round btn-remove" type="button" role="button" id="0">
                      <span class="glyphicon glyphicon-minus" data-id = '0' id="0"></span>
                    </button>
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group pull-right">
            <div class="col-md-12">
              <div class="btn-group col-md-12">
                <input type="hidden" name='totalFields' id="totalFields" value='1'>
                <button id="add" data-id = '0' class="add btn btn-round btn-success" type="button">
                  <span class="glyphicon glyphicon-plus"></span> <span class="hidden-xs">Add Fields</span>
                </button>
                <button class="btn btn-primary" type="submit">
                  <span class="glyphicon glyphicon-check"></span> <span>Submit</span></button>
                <button id="previous" class="btn btn-default" type="button"><span class="glyphicon glyphicon-share-alt"></span> <span>Previous</span></button>
              </div>
            </div>
          </div>
        </div> <!-- page two -->
      </div> <!-- centered  -->
    </div>
  </div>
</div><!-- Container -->
{{ Form::close() }}
@stop
@section('script')
<script>
  $(document).ready(function(){

    //init ...
    init();

    function init(){
        $('#name').val('{{ $itemtype->name }}');
        $('#description').val('{{ $itemtype->description }}');
        setInitialFields();
    }

    function setInitialFields(){
      var ctr = 0;
      @foreach(Itemtype::getField($itemtype->field) as $item)
        if( ctr == 0){
          $('#initField').val('{{ $item }}');
          ctr++;
        }else{
          var total = $('.add').data('id') + 1;
          setFields( total , '{{ $item }}' );
          ctr++;
        }
      @endforeach
    }

    $('#next').click(function(){
      $('#page-one').hide(400);
      $('#page-two').show(400);
    });

    $('#previous').click(function(){
      $('#page-two').hide(400);
      $('#page-one').show(400);
    });

    @if( Session::has("success-message") )
        swal("Success!","{{ Session::pull('success-message') }}","success");
    @endif

    @if( Session::has("error-message") )
        swal("Oops...","{{ Session::pull('error-message') }}","error");
    @endif

    $('.add').click(function(){
      setFields($('.add').data('id') + 1,"");
    });

    function setFields(data,value)
    {
        $('#fieldList').append(`
              <div class="col-xs-12" id="field`+data+`">
                <div class="form-group col-md-12">
                  <div class="input-group">
                    <input type="text" class="form-control field-remove" name="form`+data+`" placeholder="Field Name" value="`+value+`">
                    <span class="input-group-btn">
                      <button class="btn btn-danger btn-round btn-remove" type="button" role="button" id="`+data+`">
                        <span class="glyphicon glyphicon-minus" data-id = '`+data+`' id="`+data+`"></span>
                      </button>
                    </span>
                  </div>
                </div>
              </div>`);

        $('.add').data('id',data);
        $('#totalFields').val(data+1);
    }

    $('#fieldList').on('click','button.btn-remove',function(event){
      if($('div#fieldList').children('div').length > 1)
        $('#field'+event.target.id).remove();
      else
        swal('Error','There must be atleast one (1) field','error');
    });

    $('#page-body').show();
  });
</script>
@stop
