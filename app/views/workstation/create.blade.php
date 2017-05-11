@extends('layouts.master-blue')
@section('title')
Create Workstation
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
  <style>
    #pagetwo{
      display:none;
    }
    #pagethree{
      display:none;
    }
  </style>
@stop
@section('style-include')
  {{ HTML::style(asset('css/bootstrap-toggle.min.css')) }}
@stop
@section('script-include')
  {{ HTML::script(asset('js/bootstrap-toggle.min.js')) }}
@stop
@section('content')
<div class="container-fluid">
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
      <div class="col-sm-12 panel panel-body" style="padding: 25px;padding-top: 10px;">
        <div id="pageone" class = 'form-horizontal'>
          <ol class="breadcrumb">
            <li>
              <a href="{{ url('workstation') }}">Workstation</a>
            </li>
            <li>
              Create
            </li>
          </ol>
          {{ Form::open(array('method'=>'post','route'=>'workstation.store')) }}
          <div class="form-group">
            <div class="col-sm-12">
              {{ Form::label('name','Workstation Name') }}
              {{ Form::text('name',Input::old('name'),[
                'required',
                'class'=>'form-control',
                'placeholder'=>'Workstation Name'
              ]) }}
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-12">
              {{ Form::label('mrno','Memorandum Receipt Number (M.R. No)') }}
              {{ Form::text('mrno',Input::old('mrno'),[
                'required',
                'class'=>'form-control',
                'placeholder'=>'MR Number'
              ]) }}
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-6">
              <label>
                <input type="checkbox" checked data-toggle="toggle" data-on="Included" data-off="Not included" data-onstyle="success" data-offstyle="danger" name='keyboard'> Keyboard
              </label>
            </div>
            <div class="col-sm-6" style="padding-bottom: 10px;">
              <label>
                <input type="checkbox" checked data-toggle="toggle" data-on="Included" data-off="Not included" data-onstyle="success" data-offstyle="danger" name='mouse'> Mouse
              </label>
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-offset-9 col-sm-3">
              {{ Form::button('Next',[
                'class'=>'btn btn-primary btn-block',
                'name' => 'next',
                'id' => 'next'
              ]) }}
            </div>
          </div>

        </div>
        <div id="pagetwo" class="form-horizontal">
          <legend><h3 style="color:#337ab7;">System Unit</h3></legend>
          <div class="form-group">
            <div class="col-sm-12">
              {{ Form::label('systemunitname','Name') }}
              {{ Form::text('systemunitname',Input::old('systemunitname'),[
                'required',
                'class'=>'form-control',
                'placeholder'=>'Name'
              ]) }}
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-12">
              {{ Form::label('systemunitproperty','Property Number') }}
              {{ Form::text('systemunitproperty',Input::old('systemunitproperty'),[
                'required',
                'class'=>'form-control',
                'placeholder'=>'Property Number'
              ]) }}
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-12">
              {{ Form::label('systemunitserialid','Serial ID') }}
              {{ Form::text('systemunitserialid',Input::old('systemunitserialid'),[
                'required',
                'class'=>'form-control',
                'placeholder'=>'Serial ID'
              ]) }}
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-6 col-sm-3">
                {{ Form::button('Back',[
                  'class'=>'btn btn-info btn-block',
                  'name' => 'back',
                  'id' => 'back'
                ]) }}
            </div>
            <div class="col-sm-3">
                {{ Form::button('Next',[
                  'class'=>'btn btn-primary btn-block',
                  'name' => 'next',
                  'id' => 'nexttwo'
                ]) }}
            </div>
          </div>
        </div>
        <div id="pagethree" class="form-horizontal">
          <legend><h3 style="color:#337ab7;">Display</h3></legend>
          <div class="form-group">
            <div class="col-sm-12">
              {{ Form::label('displayname','Name') }}
              {{ Form::text('displayname',Input::old('displayname'),[
                'required',
                'class'=>'form-control',
                'placeholder'=>'Name'
              ]) }}
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-12">
              {{ Form::label('displayproperty','Property Number') }}
              {{ Form::text('displayproperty',Input::old('displayproperty'),[
                'required',
                'class'=>'form-control',
                'placeholder'=>'Property Number'
              ]) }}
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-12">
              {{ Form::label('displayserialid','Serial ID') }}
              {{ Form::text('displayserialid',Input::old('displayserialid'),[
                'required',
                'class'=>'form-control',
                'placeholder'=>'Serial ID'
              ]) }}
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-offset-6 col-sm-3">
              {{ Form::submit('Create',[
                'class'=>'btn btn-primary btn-block',
                'name' => 'create'
              ]) }}
            </div>
           <div class="col-sm-3">
              {{ Form::button('Back',[
                'class'=>'btn btn-info btn-block',
                'name' => 'back',
                'id' => 'backtwo'
              ]) }}
            </div>
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

    $('#next').click(function(){
      $('#pageone').hide(400);
      $('#pagetwo').show(400);
    });

    $('#nexttwo').click(function(){
      $('#pagetwo').hide(400);
      $('#pagethree').show(400);

    });

    $('#back').click(function(){
      $('#pagetwo').hide(400);
      $('#pageone').show(400);

    });

    $('#backtwo').click(function(){
      $('#pagethree').hide(400);
      $('#pagetwo').show(400);

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
