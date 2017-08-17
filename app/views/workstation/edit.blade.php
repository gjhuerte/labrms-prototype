@extends('layouts.master-blue')
@section('title')
Update Workstation
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('script-include')
<script type="text/javascript" src="{{ asset('js/selectize.js') }}"></script>
@stop
@section('style')
<link rel="stylesheet" href="{{ asset('css/selectize.bootstrap3.css') }}" type="text/css">
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
      <div class="col-sm-12 panel panel-body " >
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
              Update
            </li>
            <li class="active">
              {{ $pc->id }}
            </li>
          </ol>
          {{ Form::open(array('method'=>'put','route'=>array('workstation.update',$pc->id))) }}
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
              <p>
                <span class="text-danger">Old Value:</span>
                <span class="text-muted">
                  @if($pc->systemunit)
                  {{ $pc->systemunit->propertynumber }}
                  @else
                  None
                  @endif
                </span>
              </p>
              <p class="text-success">New Value:</p>
              {{ Form::select('systemunit',[],Input::old('systemunit'),[
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
              <p>
                <span class="text-danger">Old Value:</span>
                <span class="text-muted">
                  @if($pc->monitor)
                  {{ $pc->monitor->propertynumber }}
                  @else
                  None
                  @endif
                </span>
              </p>
              <p class="text-success">New Value:</p>
              {{ Form::select('monitor',[],Input::old('monitor'),[
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
              <p>
                <span class="text-danger">Old Value:</span>
                <span class="text-muted">
                  @if($pc->avr)
                  {{ $pc->avr->propertynumber }}
                  @else
                  None
                  @endif
                </span>
              </p>
              <p class="text-success">New Value:</p>
              {{ Form::select('avr',[],Input::old('avr'),[
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
              <p>
                <span class="text-danger">Old Value:</span>
                <span class="text-muted">
                  @if($pc->keyboard)
                  {{ $pc->keyboard->propertynumber }}
                  @else
                  None
                  @endif
                </span>
              </p>
              <p class="text-success">New Value:</p>
              {{ Form::select('keyboard',[],Input::old('keyboard'),[
                'id'=>'keyboard',
                'class'=>'form-control',
                'placeholder' => 'Keyboard'
              ]) }}
            </div>
          </div>

  				<div class="col-sm-12">
  					<div class="form-group">
              Mouse
              <div class="material-switch pull-right">
                  <input id="mouse" name="mouse" type="checkbox" />
                  <label for="mouse" class="label-success"></label>
              </div>
  						<p style="font-size: 10px;"><span class="text-primary">Note:</span><span class="text-muted">Checked means that mouse is included</span></p>
  					</div>
  				</div>

          <div class="form-group">
            <div class="col-sm-12">
              <button class="btn btn-primary btn-lg btn-block btn-flat" name="create" type="submit"><span class="glyphicon glyphicon-check"></span> Update</button>
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

		$('#avr-help,#monitor-help,#systemunit-help,#keyboard-help,#os-help').click(function(event){
			$("#"+event.target.  id).popover('show')
		});

    init();

    function init()
    {
      setDefault();
      setSelectBox( "{{ url('get/item/profile/systemunit/unassigned') }}" , '#systemunit' );
      setSelectBox( "{{ url('get/item/profile/monitor/unassigned') }}" , '#monitor' );
      setSelectBox( "{{ url('get/item/profile/avr/unassigned') }}" , '#avr' );
      setSelectBox( "{{ url('get/item/profile/keyboard/unassigned') }}" , '#keyboard' );
    }

    function setSelectBox(url,object)
    {
      $.ajax({
        type: 'get',
        url: url,
        dataType: 'json',
        success: function(response){
          items = "";
          for(ctr = 0;ctr<response.length;ctr++){
            items += `<option value=`+response[ctr].propertynumber+`>
            `+response[ctr].propertynumber+`
            </option>`;
          }

          if(response.length == 0){
              items += `<option>There are no available property number</option>`
          }

          $(object).html("");
          $(object).append(items);
          $(object).selectize();
        }
      });
    }

    function setDefault()
    { 
      @if(Input::old('os'))
      $('#os').val('{{ Input::old('os') }}')
      @else
      $('#os').val('{{ $pc->oskey }}')
      @endif
      @if($pc->mouse == '1')
      $('#mouse').prop('checked','checked');
      @endif
    }


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
