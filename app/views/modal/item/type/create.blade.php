<style>
  #page-two, #page-body{
    display: none;
  }
</style>
<div class="modal fade" id="createItemTypeModal" tabindex="-1" role="dialog" aria-labelledby="createItemTypeModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				{{ Form::open(array('class' => 'form-horizontal','method'=>'post','route'=>'item.type.store','id'=>'itemTypeForm')) }}
				<div class="panel panel-body">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <div id="page-one">
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
			              {{ Form::label('description','Description') }}
			              {{ Form::textarea('description',Input::old('description'),[
			                'class'=>'form-control',
			                'placeholder'=>'Description'
			              ]) }}
			            </div>
			          </div>
			          <div class="form-group">
			            <div class="col-sm-offset-8 col-sm-4">
			              <button id="next" class="btn btn-block btn-flat btn-md btn-primary" type="button">
			                <span class="glyphicon glyphicon-share-alt"></span> <span class="hidden-xs">Next</span>
			              </button>
			            </div>
			          </div>
			        </div> <!-- end of page one -->
			        <div id="page-two"> <!-- page two -->
			            <legend class="text-muted">Fields</legend>
			          <div id="fieldList">
			            <div class="col-xs-12" id="field0">
			              <div class="form-group col-md-12">
			                <div class="input-group">
			                  <input type="text" class="form-control field-remove" name="form0" placeholder="Field Name">
			                  <span class="input-group-btn">
			                    <button class="btn btn-danger btn-block btn-round btn-remove" type="button" role="button" id="0">
			                      <span class="glyphicon glyphicon-minus" data-id = '0' id="0"></span>
			                    </button>
			                  </span>
			                </div>
			              </div>
			            </div>
			          </div>
			          <div class="form-group col-md-12">
			            <div class="col-md-12">
			              <div class="pull-left">
			                <input type="hidden" name='totalFields' id="totalFields" value='1'>
			                <button id="add" data-id = '0' class="add btn-flat btn btn-success" type="button" style="padding:10px;">
		                      <span class="glyphicon glyphicon-plus"></span> <span class="hidden-xs">Add Fields</span>
			                </button>
                    </div>
			              <div class="pull-right">
                      <button id="previous" class="btn btn-flat btn-default" type="button" style="padding:10px;">
                        <span class="glyphicon glyphicon-share-alt"></span>
                        <span> Previous</span>
                      </button>
			                <button class="btn btn-flat btn-primary" type="submit" style="padding:10px;">
			                  <span class="glyphicon glyphicon-check"></span>
                        <span> Submit</span>
                      </button>
			              </div>
			            </div>
			          </div>
			        </div> <!-- page two -->
			    </div>
				{{ Form::close() }}
			</div> <!-- end of modal-body -->
		</div> <!-- end of modal-content -->
	</div>
</div>
<script>
	$(document).ready(function(){

	    $('#next').click(function(){
	      $('#page-one').hide(400);
	      $('#page-two').show(400);
	    });

	    $('#previous').click(function(){
	      $('#page-two').hide(400);
	      $('#page-one').show(400);
	    });

	    $('.add').click(function(){
	      var data =  $('.add').data('id') + 1;
	      $('#fieldList').append(`
	            <div class="col-xs-12" id="field`+data+`">
	              <div class="form-group col-md-12">
	                <div class="input-group">
	                  <input type="text" class="form-control field-remove" name="form`+data+`" placeholder="Field Name">
	                  <span class="input-group-btn">
	                    <button class="btn btn-danger btn-round btn-remove" type="button" role="button" id="`+data+`">
	                      <span class="glyphicon glyphicon-minus" data-id = '`+data+`' id="`+data+`"></span>
	                    </button>
	                  </span>
	                </div>
	              </div>
	            </div>`);

	      $('.add').data('id',data);
	      $('#totalFields').val(data+1);
	    });

	    $('#fieldList').on('click','button.btn-remove',function(event){
	      if($('div#fieldList').children('div').length > 1)
	        $('#field'+event.target.id).remove();
	      else
	        swal('Error','There must be atleast one (1) field','error');
	    });
	})
</script>
