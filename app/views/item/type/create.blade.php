@extends('layouts.master-blue')
@section('title')
Create
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
<style>
  #page-two, #page-body{
    display: none;
  }
</style>
@endsection
@section('content')
{{ Form::open(array('class' => 'form-horizontal','method'=>'post','route'=>'item.type.store','id'=>'itemTypeForm')) }}
<div class="container-fluid" id="page-body">
  <div class="row">
    <div class="col-md-offset-3 col-md-6">
      <div class="panel panel-body ">
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
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('item/type') }}">Type</a>
            </li>
            <li class="active">Create</li>
        </ol>
        <div class="form-group">
          <div class="col-md-12">
            {{ Form::label('category','Category') }}
            {{ Form::select('category',[
                'equipment'=>'Equipment',
                'supply' => 'Supply',
                'fixture' => 'Fixture',
                'furniture' => 'Furniture'
              ],Input::old('category'),[
              'class'=>'form-control',
              'placeholder'=>'Description'
            ]) }}
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12">
            {{ Form::label('name','Item Type Name') }}
            {{ Form::text('name',Input::old('name'),[
              'class'=>'form-control',
              'placeholder'=>'Item name'
            ]) }}
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12">
            {{ Form::label('description','Description (Optional)') }}
            {{ Form::textarea('description',Input::old('description'),[
              'class'=>'form-control',
              'placeholder'=>'Description'
            ]) }}
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12">
            <button class="btn btn-primary btn-block btn-lg" type="submit">
              <span class="glyphicon glyphicon-check"></span> <span>Submit</span>
            </button>
          </div>
        </div>
      </div> <!-- centered  -->
    </div>
  </div>
</div><!-- Container -->
{{ Form::close() }}
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

    $('#page-body').show();
  });
</script>
@stop
