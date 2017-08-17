{{ HTML::style(asset('css/bootstrap-select.min.css')) }}
<div class="modal fade" id="assignSoftwareModal" tabindex="-1" role="dialog" aria-labelledby="assignSoftwareModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
				{{ Form::open(array('id'=>'assignSoftwareForm','method'=>'post','route'=>array('software.room.assign'),'class' => 'form-horizontal')) }}
	            <input type="hidden" id="assign-software" value="" name="software">
	            <input type="hidden" id="assign-room" data-room="" value="">
		        <div class="form-group">
		          <div class="col-md-12">
		            {{ Form::label('room','Room Name') }}
		            {{ Form::select('room',['Empty list'=>'Empty list'],Input::old('room'),[
		              'id' => 'room',
		              'class'=>'form-control',
		              'multiple'
		            ]) }}
		          </div>
		        </div>
		        <div class="form-group">
		          <div class="col-md-12">
		            {{ Form::button('Assign',[
		              'id' => 'assign-submit',
		              'class'=>'btn btn-lg btn-primary btn-block',
		              'name' => 'assign'
		            ]) }}
		          </div>
		        </div>
		      {{ Form::close() }}
			</div> <!-- end of modal-body -->
		</div> <!-- end of modal-content -->
	</div>
</div>
{{ HTML::script(asset('js/bootstrap-select.min.js')) }}
<script>
	$('#assignSoftwareModal').on('show.bs.modal',function(e){

		$('#assign-submit').on('click',function(){
			$.ajax({
				type: 'post',
				data: {
					'room': $('#room').val(),
					'id': $('#assign-software').val()
				},
				url: '{{ url("software/room/assign") }}',
				dataType: 'json',
				success: function(response){
					if(response == 'success')
					{
						$('#assignSoftwareModal').modal('hide')
						swal('Operation Success','Software Assigned to a Room','success')
					} else 
					{
						$('#assignSoftwareModal').modal('hide')
						swal('Operation Failed','Problem encountered while processing your request','error')
					}										
				}
			})
		})

        $.ajax({
        	type: 'get',
        	url: '{{ url("room") }}',
        	dataType: 'json',
        	success: function(response){
        		option = "";
        		var arr = [];
        		room = $('#assign-room').data('room');

        		room.forEach(function(obj){
        			arr.push(obj.room.id)
        		})

        		for( ctr = 0 ; ctr < response.data.length ; ctr++ ){

        			console.log(isIncluded(arr,response.data[ctr].id))
        			if( isIncluded(arr,response.data[ctr].id) == false )
        			{
        				option += `<option val=` + response.data[ctr].id + `>` + response.data[ctr].name + `</option>`;
        			}
        		}

        		$('#room').html("");
        		$('#room').append(option);
        	},
        	complete: function(){
        		$('#room').selectpicker('refresh');
				$('#room').selectpicker();
        	}
        })

        function isIncluded(arr,id)
        {
        	ret_val = false;
        	arr.forEach(function(obj){
        		if(obj == id)
        		{
        			ret_val = true;
        		}
        	})

        	return ret_val;
        }
	})
</script>