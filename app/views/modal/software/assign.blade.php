<div class="modal fade" id="assignSoftwareModal" tabindex="-1" role="dialog" aria-labelledby="assignSoftwareModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
				{{ Form::open(array('method'=>'put','route'=>array('software.update'),'class' => 'form-horizontal')) }}
	            <input type="hidden" value="" name="software">
		        <div class="form-group">
		          <div class="col-md-12">
		            {{ Form::label('room','Room Name') }}
		            {{ Form::select('room',['Empty list'=>'Empty list'],Input::old('room'),[
		              'id' => 'room',
		              'class'=>'form-control'
		            ]) }}
		          </div>
		        </div>
		        <div class="form-group">
		          <div class="col-md-12">
		            {{ Form::label('workstation','Workstation') }}
		            {{ Form::select('workstation',['Empty list'=>'Empty list'],Input::old('workstation'),[
		              'id' => 'workstation',
		              'class'=>'form-control'
		            ]) }}
		          </div>
		        </div>
		        <div class="form-group">
		          <div class="col-md-12">
		            {{ Form::submit('Assign',[
		              'class'=>'btn btn-lg btn-primary btn-block',
		              'name' => 'assign',
		              'multiple' => 'multiple'
		            ]) }}
		          </div>
		        </div>
		      {{ Form::close() }}
			</div> <!-- end of modal-body -->
		</div> <!-- end of modal-content -->
	</div>
</div>
<script>
	$('#assignSoftwareModal').on('show.bs.modal',function(e){

        $.ajax({
        	type: 'get',
        	url: '{{ url("room") }}',
        	dataType: 'json',
        	success: function(response){
        		option = "";
        		for( ctr = 0 ; ctr < response.data.length ; ctr++ ){
        			option += `<option val=` + response.data[ctr].id + `>` + response.data[ctr].name + `</option>`;
        		}

        		$('#room').html("");
        		$('#room').append(option);
        	},
        	complete: function(){
        		workstation();
        	}
        })
	})

	function workstation()
	{
	    var room = $('#room').val();
	    $.ajax({
	      type: 'post',
	      url: '{{ url("get/workstation/all") }}',
	      data: {'room' : room},
	      dataType: 'json',
	      success: function(response){
	      options = "";
	      if(!$.trim(response))
	      {
	          options = "<option>Empty list</option>";

	      }else{
	          for(var ctr = 0;ctr<response.length;ctr++){
	            if(response.length > 0)
	            {
	                options += "<option value='"+response[ctr].id+"'>"+response[ctr].name+"</option>";
	            }else{
	              options = "<option>Empty list</option>";
	            }
	          }
	      }
	        $('#workstation').html(" ");
	        $('#workstation').append(options);
	      },
	      error: function(response){
	      console.log(response.responseJSON);
	      }
	    });
	}
</script>