@extends('layouts.master-blue')
@section('title')
Workstation | Add
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('script-include')
<script type="text/javascript" src="{{ asset('js/standalone/selectize.js') }}"></script>
@stop
@section('style')
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
      <legend><h3 class="text-primary">Workstation <small>Bundle</small></h3></legend>
      <ul class="breadcrumb">
        <li><a href="{{ url('workstation') }}">Workstation</a></li>
        <li class="active">Add</li>
      </ul>
      {{ Form::open(['method'=>'post','route'=>array('workstation.store')]) }}
      <div id="page-one">
        <div class="form-group">
          <label for="">Acknowledgement Receipt</label>
          <input type="text" name="mrnumber" class="form-control" placeholder="Acknowledgement Receipt" />
        </div>
        <div class="form-group">
          <label for="">PO Number</label>
          <input type="text" name="ponumber" class="form-control" placeholder="P.O. Number" />
        </div>
        <div class="form-group">
          <label for="">PO Date</label>
          <input type="text" id="podate" name="podate" class="form-control" placeholder="P.O. Date" />
        </div>
        <div class="form-group">
          <label for="">Invoice Number</label>
          <input type="text" name="invoicenumber" class="form-control" placeholder="Invoice Number" />
        </div>
        <div class="form-group">
          <label for="">Invoice Date</label>
          <input type="text" id="invoicedate" name="invoicedate" class="form-control" placeholder="Invoice Date" />
        </div>
        <div class="form-group">
          <label for="">Fund Code</label>
          <input type="text" name="fundcode" class="form-control" placeholder="Fund Code" />
        </div>
        <div class="pull-right">
          <div class="btn-group btn-group">
            <div class="btn-group">
              <button type="button" id="next-1" class="btn btn-primary btn-flat" style="padding:10px 20px; margin-bottom: 10px;">Next</button>
            </div>
          </div>
        </div>
      </div>
      <div id="page-two">
        <legend>System Unit</legend>
        <div class="form-group">
          <label for="">Brand</label>
          {{ Form::text('systemunit_brand',Input::old('systemunit_brand'),[
              'class' => 'form-control',
              'placeholder' => 'Brand'
          ]) }}
        </div>
        <div class="form-group">
          <label for="">Model</label>
          {{ Form::text('systemunit_model',Input::old('systemunt_model'),[
              'class' => 'form-control',
              'placeholder' => 'Model'
          ]) }}
        </div>
        <div class="form-group">
          <label for="">Other Details</label>
          {{ Form::textarea('systemunit_specification',Input::old('systemunit_specification'),[
            'class' => 'form-control',
            'rows' => '2',
            'placeholder' => 'Other details'
          ]) }}
        </div>
        <legend>Monitor</legend>
        <div class="form-group">
          <label for="">Brand</label>
          {{ Form::text('monitor_brand',Input::old('monitor_brand'),[
            'class' => 'form-control',
              'placeholder' => 'Brand'
          ]) }}
        </div>
        <div class="form-group">
          <label for="">Model</label>
          {{ Form::text('monitor_model',Input::old('monitor_model'),[
            'class' => 'form-control',
              'placeholder' => 'Model'
          ]) }}
        </div>
        <div class="form-group">
          <label for="">Other Details</label>
          {{ Form::textarea('monitor_specification',Input::old('monitor_specification'),[
            'class' => 'form-control',
            'rows' => '2',
            'placeholder' => 'Other details'
          ]) }}
        </div>
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
              <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" style="text-decoration: none;">
                  Helper <span class="pull-right glyphicon glyphicon-triangle-bottom"></span>
                </a>
              </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse out" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">
                <div class="form-group">
                  <div class="col-sm-12">
                    {{ Form::label('quantity-to-profile','Quantity to Profile ( set ):') }}
                    <input type="number" class="form-control" id="quantity-to-profile" />
                  </div>
                </div>
                <legend>System Unit</legend>
                <div class="form-group">
                  <div class="col-sm-12">
                    {{ Form::label('propertynumber-assitant-systemunit','Property Number Constant Value Fillers:') }}
                    <p class="text-muted" style="font-size: 12px;">
                      This will fill up the 'PUP-'
                    </p>
                    <input type="text" class="form-control" id="propertynumber-assitant-systemunit" />
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-12">
                    <p class="text-muted" style="font-size: 12px;">
                      Note: This will append number after the constant value you filled up
                    </p>
                    <input type="checkbox" id="is-incrementing-systemunit" /> Is Incrementing?
                    <input type="number" placeholder="Starting Value" class="form-control" id="is-incrementing-value-systemunit" disabled />
                  </div>
                </div>
                <legend>Monitor</legend>
                <div class="form-group">
                  <div class="col-sm-12">
                    {{ Form::label('propertynumber-assitant-monitor','Property Number Constant Value Fillers:') }}
                    <p class="text-muted" style="font-size: 12px;">
                      This will fill up the 'PUP-'
                    </p>
                    <input type="text" class="form-control" id="propertynumber-assitant-monitor" />
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-12">
                    <p class="text-muted" style="font-size: 12px;">
                      Note: This will append number after the constant value you filled up
                    </p>
                    <input type="checkbox" id="is-incrementing-monitor" /> Is Incrementing?
                    <input type="number" placeholder="Starting Value" class="form-control" id="is-incrementing-value-monitor" disabled />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="pull-right">
          <div class="btn-group btn-group">
            <div class="btn-group">
              <div class="btn-group">
                <button type="button" id="previous-1" class="btn btn-default btn-flat" style="padding: 10px 20px; margin-left: 10px;">Previous</button>
              </div>
              <button type="button" id="next-2" class="btn btn-primary btn-flat" style="padding:10px 20px; margin-left: 10px;">Next</button>
            </div>
          </div>
        </div>
      </div>
      <div id="page-three">
        <table class="table table-hover table-bordered" id="workstationTable">
          <thead>
            <th></th>
            <th>System Unit</th>
            <th>Display | Monitor</th>
          </thead>
          <tbody>
          </tbody>
        </table>
        <button id="add" class="btn btn-flat btn-success" type="button" style="padding: 10px 20px;">
          <span class="glyphicon glyphicon-plus"></span> <span class="hidden-xs">Add Fields</span>
        </button>
        <button id="remove" class="btn btn-flat btn-danger" type="button" style="padding: 10px 20px;">
          <span class="glyphicon glyphicon-remove"></span> <span class="hidden-xs">Remove Field</span>
        </button>
        <div class="pull-right">
          <div class="btn-group btn-group" >
            <div class="btn-group">
              <button type="button" id="previous-2" class="btn btn-default btn-flat" style="padding: 10px 20px; margin-left: 10px;">Previous</button>
            </div>
            <div class="btn-group">
              <button type="submit" class="btn btn-primary btn-flat" style="padding: 10px 20px; margin-left: 10px;" id="submit">Submit</button>
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
{{ HTML::script(asset('js/moment.min.js')) }}
<script>
  $(document).ready(function(){

    $('#is-incrementing-systemunit').on('change',function(){
      if($('#is-incrementing-systemunit').is(':checked'))
      {
        $('#is-incrementing-value-systemunit').removeProp('disabled')
      } else {
        $('#is-incrementing-value-systemunit').prop('disabled','disabled')
      }
    })

    $('#is-incrementing-monitor').on('change',function(){
      if($('#is-incrementing-monitor').is(':checked'))
      {

        $('#is-incrementing-value-monitor').removeProp('disabled')
      } else {
        $('#is-incrementing-value-monitor').prop('disabled','disabled')
      }
    })

    $('#quantity-to-profile').on('focusin change keyup keypress',function(){
      quantity = $('#quantity-to-profile').val()

      if(quantity > 30)
      {
          $('#quantity-error').remove()
          $('#quantity-to-profile').after('<p class="text-danger" id="quantity-error" style="font-size: 12px;">Warning! Profiling more than 30 set will take longer time to process.</p>')

        $('#quantity-to-profile').val(30)
      }

      if( quantity <= 30 ) {
        $('#quantity-error').fadeOut(400,function(){ $(this).remove() })
      }
    })

    $('#next-1').on('click',function(){
      showOrHide('#page-two','#page-one')
    })

    $('#next-2').on('click',function(){

      const1_systemunit = "";
      if($('#propertynumber-assitant-systemunit').val() != "")
      {
        const1_systemunit = $('#propertynumber-assitant-systemunit').val()
      }

      const2_systemunit = "";
      if($('#is-incrementing-systemunit').is(":checked"))
      {
        const2_systemunit = $('#is-incrementing-value-systemunit').val()
      }

      const1_monitor = "";
      if($('#propertynumber-assitant-monitor').val() != "")
      {
        const1_monitor = $('#propertynumber-assitant-monitor').val()
      }

      const2_monitor = "";
      if($('#is-incrementing-monitor').is(":checked"))
      {
        const2_monitor = $('#is-incrementing-value-monitor').val()
      }

      quantity = "";
      if( $('#quantity-to-profile').val() > 0 &&  $('#quantity-to-profile').val() != "")
      {
        quantity = $('#quantity-to-profile').val();
        for( var ctr = 1 ; ctr <= quantity ; ctr++ ){
          row_num = parseInt($('#workstationTable > tbody > tr:last').text()) + 1 
          if(isNaN(row_num))
          {
           insertForm(1,const1_systemunit,const2_systemunit,const1_monitor,const2_monitor);
          }else {

            insertForm(row_num,const1_systemunit,const2_systemunit,const1_monitor,const2_monitor);
          }

          if($('#is-incrementing-systemunit').is(":checked"))
          {
            const2_systemunit++;
          }

          if($('#is-incrementing-monitor').is(":checked"))
          {
            const2_monitor++;
          }
        }
      }

      const1_monitor = ""
      const2_monitor = ""
      const1_systemunit = ""
      const2_systemunit = ""

      showOrHide('#page-three','#page-two')
    })

    $('#previous-1').on('click',function(){
      showOrHide('#page-one','#page-two')
    })

    $('#previous-2').on('click',function(){
      $('#workstationTable > tbody').html('')
      showOrHide('#page-two','#page-three')
    })

    function showOrHide(obj1,obj2)
    {
      $(obj2).slideUp(400)
      $(obj1).slideDown(400)
    }

    $('#add').on('click',function(){
      row_num = parseInt($('#workstationTable > tbody > tr:last').text()) + 1
        if(isNaN(row_num)){
          insertForm(1);
        }else{
          if(row_num <= 30) { 
            insertForm(row_num);
          } else {
            swal('Maximum number of workstation reached','Batch process can only take 30 items','error')
          }
        } 
    })

    $('#remove').on('click',function(){ 
      if( $('#workstationTable > tbody > tr:last').text() > 1 ){
        $('#workstationTable > tbody tr:last').fadeOut(400,function(){
          $(this).remove()
        })

      } else {
        swal('Warning!','You must have atleast one(1) field','error');
      }
    })

    function insertForm(row,const1_systemunit = "",const2_systemunit = "",cost1_monitor = "",cost2_monitor = "")
    {
      $('tbody').append(`
          <tr>
            <td>`+ row +`</td>
            <td>
              <input type="text" name="workstation[`+ (row-1) +`][systemunit][propertynumber]" class="form-control" placeholder="Property Number" value="`+ const1_systemunit + const2_systemunit + `" />
              <input type="text" name="workstation[`+ (row-1) +`][systemunit][serialid]" class="form-control" placeholder="Serial Number" />
            </td>
            <td>
              <input type="text" name="workstation[`+ (row-1) +`][monitor][propertynumber]" class="form-control" placeholder="Property Number" value="`+ const1_monitor + const2_monitor + `" />
              <input type="text" name="workstation[`+ (row-1) +`][monitor][serialid]" class="form-control" placeholder="Serial Number" />
            </td>
          </tr>
      `);

      $('#workstationTable > tbody > tr:last').animateCSS('fadeIn')
    }

		@if(Input::old('podate'))
			$('#podate').val('{{ Input::old('podate') }}');
			setDate("#podate");
		@else
			$('#podate').val({{ "'".Carbon\Carbon::now()->toFormattedDateString()."'" }});
			setDate("#podate");
		@endif

		$('#podate').on('change',function(){
			setDate("#podate");
		});

		$( "#podate" ).datepicker({
			  changeMonth: true,
			  changeYear: false,
			  maxAge: 59,
			  minAge: 15,
		});

		$( "#invoicedate" ).datepicker({
			  changeMonth: true,
			  changeYear: false,
			  maxAge: 59,
			  minAge: 15,
		});

		@if(Input::old('podate'))
			$('#podate').val('{{ Input::old('podate') }}');
			setDate("#podate");
		@else
			$('#podate').val({{ "'".Carbon\Carbon::now()->toFormattedDateString()."'" }});
			setDate("#podate");
		@endif

		$('#podate').on('change',function(){
			setDate("#podate");
		});

		@if(Input::old('invoicedate'))
			$('#invoicedate').val('{{ Input::old('invoicedate') }}');
			setDate("#invoicedate");
		@else
			$('#invoicedate').val({{ "'".Carbon\Carbon::now()->toFormattedDateString()."'" }});
			setDate("#invoicedate");
		@endif

		$('#invoicedate').on('change',function(){
			setDate("#invoicedate");
		});

		function setDate(object){
				var object_val = $(object).val()
				var date = moment(object_val).format('MMM DD, YYYY');
				$(object).val(date);
		}

    @if( Session::has("success-message") )
        swal("Success!","{{ Session::pull('success-message') }}","success");
    @endif
    @if( Session::has("error-message") )
        swal("Oops...","{{ Session::pull('error-message') }}","error");
    @endif

    $('#page-body').show();

    $.fn.extend({
        animateCSS: function (animationName) {
            var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
            this.addClass('animated ' + animationName).one(animationEnd, function() {
                $(this).removeClass('animated ' + animationName);
            });
        }
    });

  });
</script>
@stop
