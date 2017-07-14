{{ HTML::style(asset('css/bootstrap-select.min.css')) }}
<div class="modal fade" id="assignSoftwareModal" tabindex="-1" role="dialog" aria-labelledby="assignSoftwareModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
				{{ Form::open(array('method'=>'post','route'=>array('software.room.assign'),'class' => 'form-horizontal')) }}
	            <input type="hidden" id="assign-software" value="" name="software">
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
{{ HTML::script(asset('js/bootstrap-select.min.js')) }}
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
				$('#room').selectpicker();
        	}
        })
	})
</script>