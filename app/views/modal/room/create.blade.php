<div class="modal fade" id="createRoomModal" tabindex="-1" role="dialog" aria-labelledby="createRoomModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        {{ Form::open(array('method'=>'post','route'=>'room.store','class' => 'form-horizontal')) }}
		        <div class="form-group">
		          <div class="col-md-12">
		            {{ Form::label('name','Room Name') }}
		            {{ Form::text('name',Input::old('name'),[
		              'class'=>'form-control',
		              'placeholder'=>'Room Name'
		            ]) }}
		          </div>
		        </div>
		        <div class="form-group">
		          <div class="col-md-12">
		            {{ Form::label('description','Description') }}
		            {{ Form::textarea('description',Input::old('description'),[
		              'class'=>'form-control',
		              'placeholder'=>'Room Description'
		            ]) }}
		          </div>
		        </div>
		        <div class="form-group">
		          <div class="col-md-12">
		            {{ Form::submit('Create',[
		              'class'=>'btn btn-lg btn-primary btn-block',
		              'name' => 'create'
		            ]) }}
		          </div>
		        </div>
		      {{ Form::close() }}
			</div> <!-- end of modal-body -->
		</div> <!-- end of modal-content -->
	</div>
</div>