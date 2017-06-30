<div class="modal fade" id="createActivityModal" tabindex="-1" role="dialog" aria-labelledby="createActivityModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 style="color:#337ab7;">Create an Activity</h3>
			</div>
			<div class="modal-body">
			{{ Form::open(['method'=>'post','route'=>'equipment.support.store','class'=>'form-horizontal']) }}
				<!-- Title -->
				<div class="form-group">
					<div class="col-sm-12">
					{{ Form::label('type','Maintenance Type') }}
					</div>
				<div class="col-sm-6">
				  <input type="radio" name="maintenancetype" value='corrective' checked/> Corrective
				</div>
				<div class="col-sm-6">
				  <input type="radio" name="maintenancetype" value='preventive' /> Preventive
				</div>
				</div>
				<!-- Company -->
				<div class="form-group">
					<div class="col-sm-12">
					{{ Form::label('problem','Problem / Category') }}
					{{ Form::textarea('problem',Input::old('problem'),[
						'class'=>'form-control',
						'placeholder'=>'Problem or Category under the said type'
					]) }}
					</div>
				</div>
				<div class="form-group">
					<div class=" col-md-12">
						<button type="submit" class="btn btn-lg btn-primary btn-block">Create</button>
					</div>
				</div>
			{{ Form::close() }}
			</div> <!-- end of modal-body -->
		</div> <!-- end of modal-content -->
	</div>
</div>