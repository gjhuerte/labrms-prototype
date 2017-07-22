<div class="modal fade" id="updateRoomModal" tabindex="-1" role="dialog" aria-labelledby="updateRoomModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				{{ Form::open(array('route'=>array('room.update'),'method'=>'PUT',
		            'class' => 'form-horizontal'
		          )) }}
	          	<input type="hidden" name="id" id="edit-id" val="" />
		        <div class="form-group">
		          <div class="col-md-12">
		            {{ Form::label('name','Room Name') }}
		            {{ Form::text('name',Input::old('name'),[
		          	  'id'=>'edit-name',
		              'class'=>'form-control',
		              'placeholder'=>'Room Name'
		            ]) }}
		          </div>
		        </div>
		        <div class="form-group">
		          <div class="col-md-12">
		            {{ Form::label('description','Description') }}
		            {{ Form::textarea('description',Input::old('description'),[
					  'id'=>'edit-description',
		              'class'=>'form-control',
		              'placeholder'=>'Room Description'
		            ]) }}
		          </div>
		        </div>
	       	    <div class="form-group">
		        	<div class="col-md-12">
		            {{ Form::submit('Update',[
		              'class'=>'btn btn-lg btn-primary btn-block'
		            ]) }}
		          </div>
		        </div>
		      {{ Form::close() }}
			</div> <!-- end of modal-body -->
		</div> <!-- end of modal-content -->
	</div>
</div>