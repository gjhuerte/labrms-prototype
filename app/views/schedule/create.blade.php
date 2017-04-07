@extends('layouts.master-blue')
@section('title')
Create
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
{{ HTML::style(asset('css/jquery.timepicker.min.css')) }}
@stop
@section('script-include')
{{ HTML::script(asset('js/jquery.timepicker.min.js')) }}
@stop
@section('content')
<div class="container-fluid">
  <div class="row">
    <div class=" col-md-offset-3 col-md-6">  
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
      <div class="col-md-12 panel panel-body" style="padding: 25px;padding-top: 10px;">
        <legend><h3 style="color:#337ab7;">Schedule Creation Form</h3></legend>
        {{ Form::open(array('method'=>'post','route'=>'schedule.store','class' => 'form-horizontal')) }}
        <div class="form-group">
          <div class="col-md-12">
            {{ Form::label('name','Room Name') }}
            <select  class='form-control' name='roomname'>
            @if(empty($rooms))
              <option value='null'>No room available</option> 
            @else
              @foreach($rooms as $room)
              <option value='{{ $room->id }}'>{{ $room->name }}</option> 
              @endforeach
            @endif
            </select>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-6">
            {{ Form::label('timein','Start Time') }}
            {{ Form::text('timein',Input::old('timein'),[
              'required',
              'class'=>'form-control',
              'placeholder'=>'Hours : Minutes',
              'id' => 'starttime'
            ]) }}
          </div>          
          <div class="col-md-6">
            {{ Form::label('timeend','End Time') }}
            {{ Form::text('timeend',Input::old('timeend'),[
              'required',
              'class'=>'form-control',
              'placeholder'=>'Hours : Minutes',
              'id' => 'endtime'
            ]) }}
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12">
            {{ Form::label('facultyincharge','Faculty-in-charge') }}
            {{ Form::text('facultyincharge',Input::old('facultyincharge'),[
              'required',
              'class'=>'form-control',
              'placeholder'=>'Faculty-in-charge'
            ]) }}
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12">
            {{ Form::label('subject','Subject') }}
            {{ Form::text('subject',Input::old('subject'),[
              'required',
              'class'=>'form-control',
              'placeholder'=>'Subject'
            ]) }}
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12">
            {{ Form::label('courseyearsection','Course Year & Section') }}
            {{ Form::text('courseyearsection',Input::old('courseyearsection'),[
              'required',
              'class'=>'form-control',
              'placeholder'=>'Course Year & Section'
            ]) }}
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12">
            {{ Form::label('semester','Semester') }}
            <select  class='form-control' name='semester'>
              <option value='1'>1st</option>
              <option value='2'>2nd</option>
              <option value='summer'>Summer</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12">
            {{ Form::label('day','Day') }}
            <select  class='form-control' name='day'>
              <option value='Monday'>Monday</option>
              <option value='Tuesday'>Tuesday</option>
              <option value='Wednesday'>Wednesday</option>
              <option value='Thursday'>Thursday</option>
              <option value='Friday'>Friday</option>
              <option value='Saturday'>Saturday</option>
              <option value='Sunday'>Sunday</option>
            </select>
          </div>
        </div>
        <div class="col-md-offset-3 col-md-4">
          <div class="form-group">
            {{ Form::submit('Create',[
              'class'=>'btn btn-primary btn-block',
              'name' => 'create'
            ]) }}
          </div>
        </div>
        <div class="col-md-offset-1 col-md-4">
          <div class="form-group">
            {{ Form::button('Cancel',[
              'class'=>'btn btn-info btn-block',
              'name' => 'cancel',
              'id' => 'cancel'
            ]) }}
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
  @if( Session::has("success-message") )
      swal("Success!","{{ Session::pull('success-message') }}","success");
  @endif
  @if( Session::has("error-message") )
      swal("Oops...","{{ Session::pull('error-message') }}","error");
  @endif

  $('#cancel').click(function(){
    window.location.href = "{{ URL::to('schedule') }}";
  });

  $('#starttime').timepicker({
    timeFormat: 'h:mm p',
    interval: 30,
    minTime: '7',
    maxTime: '7:00pm',
    defaultTime: '7:00am',
    startTime: '7:00am',
    dynamic: false,
    dropdown: true,
    scrollbar: true
});  
  $('#endtime').timepicker({
    timeFormat: 'h:mm p',
    interval: 30,
    minTime: '8',
    maxTime: '9:00pm',
    defaultTime: '8:00am',
    startTime: '8:00am',
    dynamic: false,
    dropdown: true,
    scrollbar: true
});
</script>
@stop