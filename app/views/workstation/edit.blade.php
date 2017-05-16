@extends('layouts.master-white')
@section('title')
Create Workstation
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
<link rel="stylesheet" href="{{ asset('css/style.min.css') }}" />
<style>
  #pagetwo{
    display:none;
  }
  #pagethree{
    display:none;
  }
</style>
@stop
@section('content')
<div class="container-fluid" id="page-body">
  <div class="row">
    <div class="col-sm-offset-3 col-sm-6">
      <div class="col-sm-12 panel panel-body panel-shadow" >
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
        <div class = 'form-horizontal'>
          <ol class="breadcrumb">
            <li>
              <a href="{{ url('workstation') }}">Workstation</a>
            </li>
            <li>
              <a href="{{ url('workstation/view/update') }}">Update</a>
            </li>
            <li>
              Update
            </li>
          </ol>
          {{ Form::open(array('method'=>'post','route'=>array('workstation.update',$id))) }}
          <div class="form-group">
            <div class="col-sm-12">
              {{ Form::label('os','Operating System Key') }}
  						<span tabindex="0"  type="button" id="os-help" class="btn-link glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="popover" title="Help" data-trigger="focus" data-content="This field acceps operating system licence, if there are no license, you can leave this field blank" style="text-decoration: none;"></span>
              {{ Form::text('os',Input::old('os'),[
                'id' => 'os'
                'required',
                'class'=>'form-control',
                'placeholder'=>'Operating System Key'
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

  				<div class="col-sm-12">
  					<div class="form-group">
              Keyboard
              <div class="material-switch pull-right">
                  <input id="keyboard" name="keyboard" type="checkbox"/>
                  <label for="keyboard" class="label-success"></label>
              </div>
  						<p style="font-size: 10px;"><span class="text-primary">Note:</span><span class="text-muted">Turning it on means that keyboard is included</span></p>
  					</div>
  				</div>

  				<div class="col-sm-12">
  					<div class="form-group">
              Mouse
              <div class="material-switch pull-right">
                  <input id="mouse" name="mouse" type="checkbox"/>
                  <label for="mouse" class="label-success"></label>
              </div>
  						<p style="font-size: 10px;"><span class="text-primary">Note:</span><span class="text-muted">Turning it on means that mouse is included</span></p>
  					</div>
  				</div>

          <div class="form-group">
            <div class="col-sm-12">
                <button class="btn btn-primary btn-lg btn-block" name="update" type="submit"><span class="glyphicon glyphicon-check"></span> Update</button>
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

    init();

    function init()
    {
      $('#avr').val('{{{ $pc->avr->propertynumber }}}');
      $('#systemunit').val('{{{ $pc->systemunit->propertynumber }}}');
      $('#os').val('{{{ $pc->oskey }}}');
      $('#monitor').val('{{{ $pc->monitor->propertynumber }}}');
      @if($pc->keyboard == true)
      $('#keyboard').attrib('checked','checked');
      @endif
      @if($pc->mouse == true)
      $('#mouse').attrib('checked','checked');
      @endif
    }

		$('#avr-help,#monitor-help,#systemunit-help,#os-help').click(function(event){
			$("#"+event.target.id).popover('show')
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
