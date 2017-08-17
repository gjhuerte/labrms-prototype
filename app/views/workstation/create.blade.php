@extends('layouts.master-blue')
@section('title')
Workstation | Assemble
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('script-include')
<script type="text/javascript" src="{{ asset('js/standalone/selectize.js') }}"></script>
@stop
@section('style')
{{ HTML::style(asset('css/jquery-ui.min.css')) }}
{{ HTML::style(asset('css/animate.css')) }}
<link rel="stylesheet" href="{{ asset('css/selectize.bootstrap3.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/style.min.css') }}" />
<style>
  {
    display:none;
  }
  #page-body,#page-two,#page-three{
    display:none;
  }

  .form-control{
    margin: 10px 0px;
  }
</style>
@stop
@section('content')
<div class="container-fluid" id="page-body">
  <div class="panel panel-default col-md-offset-3 col-md-6" style="padding:10px;">
    <div class="panel-body">
      <legend><h3 class="text-primary">Workstation</h3></legend>
      <ul class="breadcrumb">
        <li><a href="{{ url('workstation') }}">Workstation</a></li>
        <li class="active">Assemble</li>
      </ul>
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
      {{ Form::open(['method'=>'post','route'=>array('workstation.store')]) }}
          <div class="form-group">
            <div class="col-sm-12">
              {{ Form::label('os','Operating System Key') }}
              <span tabindex="0"  type="button" id="os-help" class="btn-link glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="popover" title="Help" data-trigger="focus" data-content="This field acceps operating system licence, if there are no license, you can leave this field blank" style="text-decoration: none;"></span>
              {{ Form::text('os',Input::old('os'),[
                'id' => 'os',
                'class'=>'form-control',
                'placeholder'=>'Operating System Key',
                'required'
              ]) }}
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-12">
              {{ Form::label('systemunit','System Unit') }}
              <span tabindex="0" type="button" id="systemunit-help" class="btn-link glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="popover" title="Help" data-trigger="focus" data-content="This field accepts a property number of existing system unit" style="text-decoration: none;"></span>
              {{ Form::text('systemunit',Input::old('systemunit'),[
                'id'=>'systemunit',
                'class'=>'form-control',
                'placeholder' => 'System Unit'
              ]) }}
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-12">
              {{ Form::label('monitor','Monitor') }}
              <span tabindex="0"  type="button" id="monitor-help" class="btn-link glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="popover" title="Help" data-trigger="focus" data-content="This field accepts a property number of existing monitor" style="text-decoration: none;"></span>
              {{ Form::text('monitor',Input::old('monitor'),[
                'id'=>'monitor',
                'class'=>'form-control',
                'placeholder' => 'Monitor'
              ]) }}
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-12">
              {{ Form::label('avr','AVR') }}
              <span tabindex="0"  type="button" id="avr-help" class="btn-link glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="popover" data-trigger="focus" title="Help" data-content="This field accepts a property number of existing avr" style="text-decoration: none;"></span>
              {{ Form::text('avr',Input::old('avr'),[
                'id'=>'avr',
                'class'=>'form-control',
                'placeholder' => 'AVR'
              ]) }}
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-12">
              {{ Form::label('keyboard','Keyboard') }}
              <span tabindex="0"  type="button" id="keyboard-help" class="btn-link glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="popover" data-trigger="focus" title="Help" data-content="This field accepts a property number of existing keyboard" style="text-decoration: none;"></span>
              {{ Form::text('keyboard',Input::old('keyboard'),[
                'id'=>'keyboard',
                'class'=>'form-control',
                'placeholder' => 'Keyboard'
              ]) }}
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-12">
              {{ Form::label('mouse','Mouse Brand') }}
              <span tabindex="0"  type="button" id="keyboard-help" class="btn-link glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="popover" data-trigger="focus" title="Help" data-content="This field accepts a property number of existing mouse" style="text-decoration: none;"></span>
              {{ Form::text('mouse',Input::old('mouse'),[
                'id'=>'mouse',
                'class'=>'form-control',
                'placeholder' => 'Mouse'
              ]) }}
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-12">
              <button class="btn btn-primary btn-lg btn-block btn-flat" name="create" type="submit"><span class="glyphicon glyphicon-check"></span> Assemble</button>
            </div>
          </div>
        </div>
      {{ Form::close() }}
    </div>
  </div>
</div><!-- Container -->
@stop
@section('script')
{{ HTML::script(asset('js/jquery-ui.js')) }}
{{ HTML::script(asset('js/moment.min.js')) }}
<script>
  $(document).ready(function(){

    $('#keyboard').autocomplete({
      source: "{{ url('get/item/profile/keyboard/propertynumber') }}"
    });

    $('#monitor').autocomplete({
      source: "{{ url('get/item/profile/monitor/propertynumber') }}"
    });

    $('#systemunit').autocomplete({
      source: "{{ url('get/item/profile/systemunit/propertynumber') }}"

    });

    $('#avr').autocomplete({
      source: "{{ url('get/item/profile/avr/propertynumber') }}"

    });

    $('#mouse').autocomplete({
      source: "{{ url('get/supply/mouse/brand') }}"
    });

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
