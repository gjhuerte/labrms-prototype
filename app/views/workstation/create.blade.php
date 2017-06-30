@extends('layouts.master-blue')
@section('title')
Assemble Workstation
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('script-include')
<script type="text/javascript" src="{{ asset('js/standalone/selectize.js') }}"></script>
@stop
@section('style')
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

  .panel{
    padding: 10px;
  }
</style>
@stop
@section('content')
<div class="container-fluid" id="page-body">
  <div class="panel panel-default col-md-offset-3 col-md-6">
    <div class="panel-body">
      <legend><h3 class="text-primary">Workstation <small>Bundle</small></h3></legend>
      <ul class="breadcrumb">
        <li><a href="{{ url('workstation') }}">Workstation</a></li>
        <li class="active">Assemble</li>
      </ul>
      <div id="page-one">
        <div class="form-group">
          <label for="">MR Number</label>
          <input type="text" class="form-control" />
        </div>
        <div class="form-group">
          <label for="">PO Number</label>
          <input type="text" class="form-control" />
        </div>
        <div class="form-group">
          <label for="">PO Date</label>
          <input type="text" class="form-control" />
        </div>
        <div class="form-group">
          <label for="">Invoice Number</label>
          <input type="text" class="form-control" />
        </div>
        <div class="form-group">
          <label for="">Invoice Date</label>
          <input type="text" class="form-control" />
        </div>
        <div class="form-group">
          <label for="">Fund Code</label>
          <input type="text" class="form-control" />
        </div>
        <div class="pull-right">
          <div class="btn-group btn-group">
            <div class="btn-group"> 
              <button id="next-1" class="btn btn-primary btn-flat" style="padding:10px 20px; margin-bottom: 10px;">Next</button>
            </div>
          </div>
        </div>
      </div>
      <div id="page-two">
        <div class="form-group">
          <label for="">System Unit Specifications</label>
          <textarea class="form-control" placeholder="Enter Details here..."></textarea>
        </div>
        <div class="form-group">
          <label for="">Monitor Specifications</label>
          <textarea class="form-control" placeholder="Enter Details here..."></textarea>
        </div>
        <div class="form-group">
          <label for="">AVR Specifications</label>
          <textarea class="form-control" placeholder="Enter Details here..."></textarea>
        </div>
        <div class="form-group">
          <label for="">Keyboard Specifications</label>
          <textarea class="form-control" placeholder="Enter Details here..."></textarea>
        </div>
        <div class="pull-right">
          <div class="btn-group btn-group">
            <div class="btn-group"> 
              <div class="btn-group"> 
                <button id="previous-1" class="btn btn-default btn-flat" style="padding: 10px 20px; margin-left: 10px;">Previous</button>
              </div>
              <button id="next-2" class="btn btn-primary btn-flat" style="padding:10px 20px; margin-left: 10px;">Next</button>
            </div>
          </div>
        </div>
      </div>
      <div id="page-three">
        <table class="table table-hover table-bordered">
          <thead>
            <th></th> 
            <th>System Unit</th>
            <th>Display</th>
            <th>AVR</th>
            <th>Keyboard</th>
          </thead>
          <tbody>
            <td>1</td>
            <td>
              <input type="text" class="form-control" placeholder="Property Number">
              <input type="text" class="form-control" placeholder="Serial Number"></td>
            <td>
              <input type="text" class="form-control" placeholder="Property Number">
              <input type="text" class="form-control" placeholder="Serial Number"></td>
            <td>
              <input type="text" class="form-control" placeholder="Property Number">
              <input type="text" class="form-control" placeholder="Serial Number"></td>
            <td>
              <input type="text" class="form-control" placeholder="Property Number">
              <input type="text" class="form-control" placeholder="Serial Number"></td>
          </tbody>
        </table>
        <div class="pull-right">
          <div class="btn-group btn-group" >
            <div class="btn-group"> 
              <button id="previous-2" class="btn btn-default btn-flat" style="padding: 10px 20px; margin-left: 10px;">Previous</button>
            </div>
            <div class="btn-group">
              <button id="submit" class="btn btn-primary btn-flat" style="padding: 10px 20px; margin-left: 10px;">Submit</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div><!-- Container -->
@stop
@section('script')
<script>
  $(document).ready(function(){

    $('#next-1').on('click',function(){
      showOrHide('#page-two','#page-one')
    })

    $('#next-2').on('click',function(){
      showOrHide('#page-three','#page-two')
      changeClass('.panel-default','col-md-12','col-md-offset-3 col-md-6')
    })

    $('#previous-1').on('click',function(){
      showOrHide('#page-one','#page-two')
    })

    $('#previous-2').on('click',function(){
      showOrHide('#page-two','#page-three')
      changeClass('.panel-default','col-md-offset-3 col-md-6','col-md-12')
    })

    function changeClass(obj1,class1,class2)
    {
      $(obj1).addClass(class1,500);
      $(obj1).removeClass(class2,500);
    }

    function showOrHide(obj1,obj2)
    {
      $(obj2).slideUp(400)
      $(obj1).slideDown(400)
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
