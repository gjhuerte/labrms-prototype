<div class="modal fade" id="updateActivityModal" tabindex="-1" role="dialog" aria-labelledby="updateActivityModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				{{ Form::open(['method'=>'put','route'=>array('maintenance.activity.update'),'class'=>'form-horizontal']) }}
				<input type="hidden" name="id" value="" id="edit-id" />
				<!-- Title -->
				<div class="form-group">
					<div class="col-sm-12">
					{{ Form::label('type','Maintenance Type') }}
					</div>
					<div class="col-sm-6">
					  <input type="radio" name="maintenancetype" id='edit-corrective' value='corrective' checked/> Corrective
					</div>
					<div class="col-sm-6">
					  <input type="radio" name="maintenancetype" id="edit-preventive" value='preventive' /> Preventive
					</div>
				</div>
				<!-- Company -->
				<div class="form-group">
					<div class="col-sm-12">
					{{ Form::label('problem','Problem / Category') }}
					{{ Form::textarea('problem',Input::old('problem'),[
						'id' => 'edit-problem',
						'class'=>'form-control',
						'placeholder'=>'Problem or Category under the said type'
					]) }}
					</div>
				</div>
				<div class="form-group">
					<div class=" col-md-12">
						<button type="submit" class="btn btn-lg btn-primary btn-block">Update</button>
					</div>
			</div>
			{{ Form::close() }}
			</div> <!-- end of modal-body -->
		</div> <!-- end of modal-content -->
	</div>
</div>