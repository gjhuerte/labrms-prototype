<div class="modal fade" id="itemAddModal" tabindex="-1" role="dialog" aria-labelledby="itemAddModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 style="color:#337ab7;">Item Information</h3>
			</div>
			<div class="modal-body">
        <div class="panel default">
            <div class="panel-body">
              {{ Form::open(['class'=>'form-horizontal']) }}
        			<!-- Item name -->
        			<div class="form-group">
        				<div class="col-sm-3">
        				{{ Form::label('itemtypes','Item types') }}
        				</div>
        				<div class="col-sm-9">
        				{{ Form::select('itemtypes',['Loading all item types'],Input::old('itemtypes'),[
        					'id'=>'itemtype',
        					'class'=>'form-control'
        				]) }}
        				</div>
        			</div>
        			<!-- Item name -->
        			<div class="form-group">
        				<div class="col-sm-3">
        				{{ Form::label('itembrand','Item brand') }}
        				</div>
        				<div class="col-sm-9">
        				{{ Form::select('itembrand',['Loading all item brands'],Input::old('itembrand'),[
        					'id'=>'itembrand',
        					'class'=>'form-control'
        				]) }}
        				</div>
        			</div>
        			<!-- Item name -->
        			<div class="form-group">
        				<div class="col-sm-3">
        				{{ Form::label('itemmodel','Item model') }}
        				</div>
        				<div class="col-sm-9">
        				{{ Form::select('itemmodel',['Loading all item models'],Input::old('itemmodel'),[
        					'id'=>'itemmodel',
        					'class'=>'form-control'
        				]) }}
        				</div>
        			</div>
        			<!-- Item name -->
        			<div class="form-group">
        				<div class="col-sm-3">
        				{{ Form::label('propertynumber','Property Number') }}
        				</div>
        				<div class="col-sm-9">
        				{{ Form::select('propertynumber',['Loading all Property Number'],Input::old('propertynumber'),[
        					'id'=>'propertynumber',
        					'class' => 'form-control'
        				]) }}
        				</div>
        			</div>
        			<!-- Item name -->
        			<div class="form-group">
        				<div class="col-sm-12">
                  <button type="button" id="item-list-adder" class="btn btn-primary btn-lg btn-block">Add</button>
        				</div>
        			</div>
              {{ Form::close() }}
            </div>
        </div>
			</div> <!-- end of modal-body -->
		</div> <!-- end of modal-content -->
	</div>
</div>
