{{ Form::open(['method'=>'post','route'=>'reservation.items.list.store','class'=>'form-horizontal']) }}
<div class="modal fade" id="reservationItemsAddModal" tabindex="-1" role="dialog" aria-labelledby="reservationItemsAddModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 style="color:#337ab7;">Create a rule</h3>
			</div>
			<div class="modal-body">
        <div class="panel panel-default panel-body" style="border:none;">
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
          <div class="col-md-12" style="margin: 10px 0;">
            {{ Form::label('included','Included Items') }}
            <p class="text-muted">Instructions: Write all property number you want to include and separate it by comma</p>
            <p class="text-warning">Note: Leaving this blank means you want to include all items.</p>
            {{ Form::textarea('included',Input::old("included"),[
                'id' => 'included',
                'class' => 'form-control',
                'data-autoresize'
            ]) }}
          </div>
          <div class="col-md-12" style="margin: 10px 0;">
            {{ Form::label('excluded','Excluded Items') }}
            <p class="text-muted">Instructions: Write all property number you want to include and separate it by comma</p>
            <p class="text-danger">Note: All items added will not be included in students and faculty reservation.</p>
            {{ Form::textarea('excluded',Input::old("excluded"),[
                'id' => 'excluded',
                'class' => 'form-control',
                'data-autoresize'
            ]) }}
          </div>
          <div class="col-md-12" style="margin: 10px 0;">
            <button type="submit" class="btn btn-flat btn-primary btn-lg btn-block">Submit</button>
          </div>
        </div>
			</div> <!-- end of modal-body -->
		</div> <!-- end of modal-content -->
	</div>
</div>
{{ Form::close() }}

<script>
$(document).ready(function(){

  init();

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
})
</script>
