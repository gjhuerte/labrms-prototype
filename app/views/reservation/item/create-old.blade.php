@extends('layouts.master-blue')
@section('title')
Create
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
<link href="{{ asset('css/smart_wizard.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/smart_wizard_theme_arrows.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
<style>
  #page-two, #page-body{
    display: none;
  }

  #step-4 > .col-md-12 > ul > li  {
      margin: 15px 0px;
  }

</style>
@endsection
@section('content')
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
      {{ Form::open(['method'=>'post','route'=>'reservation.items.list.store','class'=>'form-horizontal']) }}
        <div id="smartwizard" class="panel panel-default panel-body" style="padding: 20px 10px;margin: 10px;">
          <ul>
              <li><a href="#step-1">Basic Information<br /><small></small></a></li>
              <li><a href="#step-2">Included<br /><small></small></a></li>
              <li><a href="#step-3">Excluded<br /><small></small></a></li>
              <li><a href="#step-4">Complete<br /><small></small></a></li>
          </ul>

          <div style="padding: 20px 10px;">
              <div id="step-1" class="form-group">
                <div class="col-md-12" style="margin: 10px 0;">
                {{ Form::label('itemtype','Item type') }}
                {{ Form::select('itemtype',['Loading...'],Input::old("itemtype"),[
                    'id' => 'itemtype',
                    'class' => 'form-control'
                ]) }}
                </div>
                <div class="col-md-12" style="margin: 10px 0;">
                  {{ Form::label('brand','Brand') }}
                  {{ Form::select('brand',['Loading...'],Input::old("brand"),[
                      'id' => 'brand',
                      'class' => 'form-control'
                  ]) }}
                </div>
                <div class="col-md-12" style="margin: 10px 0;">
                {{ Form::label('model','Model') }}
                {{ Form::select('model',['Loading...'],Input::old("model"),[
                    'id' => 'model',
                    'class' => 'form-control'
                ]) }}
                </div>
              </div>
              <div id="step-2" class="form-group">
                <div class="col-md-12">
                  {{ Form::label('included','Included Items') }}
                  <p class="text-muted">Instructions: Write all property number you want to include and separate it by comma</p>
                  <p class="text-warning">Note: Leaving this blank means you want to include all items.</p>
                  {{ Form::textarea('included',Input::old("included"),[
                      'id' => 'included',
                      'class' => 'form-control'
                  ]) }}
                </div>
              </div>
              <div id="step-3" class="form-group">
                <div class="col-md-12">
                  {{ Form::label('excluded','Excluded Items') }}
                  <p class="text-muted">Instructions: Write all property number you want to include and separate it by comma</p>
                  <p class="text-danger">Note: All items added will not be included in students and faculty reservation.</p>
                  {{ Form::textarea('excluded',Input::old("excluded"),[
                      'id' => 'excluded',
                      'class' => 'form-control'
                  ]) }}
                </div>
              </div>
              <div id="step-4" class="form-group">
                <div class="col-md-12">
                  <legend class="text-center text-muted ">Preview</legend>
                  <ul class='list-unstyled text-muted'>
                    <li>Item Type: <span id="itemtype-note"></span></li>
                    <li>Brand: <span id="brand-note"></span></li>
                    <li>Model: <span id="model-note"></span></li>
                    <li>Included: <span id="included-note"></span></li>
                    <li>Excluded: <span id="excluded-note"></span></li>
                  </ul>
                  <button type="submit" class="btn btn-flat btn-primary btn-lg btn-block">Submit</button>
                </div>
              </div>
          </div>
        </div>
      {{ Form::close() }}
    </div>
  </div>
</div><!-- Container -->
@stop
@section('script')
<script type="text/javascript" src="{{ asset('js/jquery.smartWizard.min.js') }}"></script>
<script>
  $(document).ready(function(){
    $('#smartwizard').smartWizard({
      selected: 0,  // Initial selected step, 0 = first step
      transitionEffect: 'fade', // Effect on navigation, none/slide/fade
    });

    init();

    $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection) {
       if(stepNumber == 3)
       {
          $('#itemtype-note').html($("#itemtype option:selected").text())
          $('#brand-note').html($("#brand").val())
          $('#model-note').html($("#model").val())
          $('#included-note').html($("#included").val())
          $('#excluded-note').html($("#excluded").val())
       }
    });

    @if( Session::has("success-message") )
        swal("Success!","{{ Session::pull('success-message') }}","success");
    @endif

    @if( Session::has("error-message") )
        swal("Oops...","{{ Session::pull('error-message') }}","error");
    @endif

    function init()
    {
      $.ajax({
        type: 'get',
        url: '{{ url("get/item/type/all") }}',
        dataType: 'json',
        success: function(response){
          var options = "";

          for(var ctr = 0;ctr < response.length;ctr++)
          {
            options += `<option value="`+response[ctr].id+`">
              `+response[ctr].name+`
            </option>`;
          }

          if(response.length == 0)
          {
            options = `<option>No record found</option>`;
          }

          $('#itemtype').html("");
          $('#itemtype').append(options);
        },
        complete: function(){
          @if(Input::old('itemtype'))
          $('#itemtype').val("{{ Input::old('itemtype') }}")
          @endif
          setBrand();
        }
      })
    }

    function setBrand()
    {
      $.ajax({
        type: 'get',
        url: '{{ url("get/item/brand/all") }}',
        data: {
          'itemtype': $('#itemtype').val()
        },
        dataType: 'json',
        success: function(response){
          var options = "";

          for(var ctr = 0;ctr < response.length;ctr++)
          {
            options += `<option value="`+response[ctr].brand+`">
              `+response[ctr].brand+`
            </option>`;
          }

          if(response.length == 0)
          {
            options = `<option>No record found</option>`;
          }

          $('#brand').html("");
          $('#brand').append(options);
        },

        complete: function(){
          @if(Input::old('brand'))
          $('#brand').val("{{ Input::old('brand') }}")
          @endif
          setModel();
        }
      })
    }

    function setModel()
    {
      $.ajax({
        type: 'get',
        url: '{{ url("get/item/model/all") }}',
        data: {
          'brand': $('#brand').val()
        },
        dataType: 'json',
        success: function(response){
          var options = "";

          for(var ctr = 0;ctr < response.length;ctr++)
          {
            options += `<option value="`+response[ctr].model+`">
              `+response[ctr].model+`
            </option>`;
          }

          if(response.length == 0)
          {
            options = `<option>No record found</option>`;
          }

          $('#model').html("");
          $('#model').append(options);
        },
        complete: function(){
          @if(Input::old('model'))
          $('#model').val("{{ Input::old('model') }}")
          @endif
        }
      })
    }

    $('#itemtype').on('change',function(){
      setBrand();
    });

    $('#brand').on('change',function(){
      setModel();
    });

    $('#page-body').show();
  });
</script>
@stop
