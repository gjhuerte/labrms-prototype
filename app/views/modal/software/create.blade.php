<style>
	#page-two{
		display:none;
	}
</style>
<div class="modal fade" id="createSoftwareModal" tabindex="-1" role="dialog" aria-labelledby="createSoftwareModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>			
				{{ Form::open(['method'=>'post','route'=>'software.store','class'=>'form-horizontal']) }}
				<div id="page-one">
					<!-- Title -->
					<div class="form-group">
						<div class="col-sm-12">
						{{ Form::label('name','Software Name') }}
						{{ Form::text('name',Input::old('name'),[
							'class'=>'form-control',
							'placeholder'=>'Software Name'
						]) }}
						</div>
					</div>
					<!-- Company -->
					<div class="form-group">
						<div class="col-sm-12">
						{{ Form::label('company','Company') }}
						{{ Form::text('company',Input::old('company'),[
							'class'=>'form-control',
							'placeholder'=>'Company'
						]) }}
						</div>
					</div>
					<!-- License Type -->
					<div class="form-group">
						<div class="col-sm-12">
						{{ Form::label('licensetype','License Type') }}
						{{ Form::select('licensetype',['Loading all License Types ...'],Input::old('licensetype'),[
							'id' => 'licensetype',
							'class' => 'form-control'
						]) }}
						</div>
					</div>
					<!-- Software types -->
					<div class="form-group">
						<div class="col-sm-12">
						{{ Form::label('softwaretype','Software Type') }}
						{{ Form::select('softwaretype',['Loading all Software Types ...'],Input::old('softwaretype'),[
							'id' => 'softwaretype',
							'class' => 'form-control'
						]) }}
						</div>
					</div>
					<!-- License -->
					<div class="form-group">
						<div class="col-sm-12">
						{{ Form::label('licensekey','License Key') }}
						{{ Form::text('licensekey',Input::old('licensekey'),[
							'class'=>'form-control',
							'placeholder'=>'License Key'
						]) }}
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
				            Multiple Usage
				            <div class="material-switch pull-right">
				                <input id="multiple" name="multiple" type="checkbox"/>
				                <label for="multiple" class="label-success"></label>
				            </div>
							<p style="font-size: 10px;"><span class="text-danger">Note:</span><span class="text-muted">Turning this off means that this license is for single use only</span></p>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
							<button type="button" class="btn btn-primary col-md-offset-9 col-md-3" id="next">Next</button>
						</div>
					</div>
				</div>
				<div id="page-two">
					<div class="form-group">
						<!-- description -->
						<div class="col-sm-12">
							{{ Form::label('minrequirement','Minimum System Requirements') }}
							{{ Form::textarea('minrequirement',Input::old('minrequirement'),[
								'class'=>'form-control',
								'placeholder'=>'Enter minimum system requirements here...',
								'data-autoresize',
								'rows' => '2'
							]) }}
						</div>
					</div>
					<div class="form-group">
						<!-- description -->
						<div class="col-sm-12">
							{{ Form::label('maxrequirement','Maximum System Requirements') }}
							{{ Form::textarea('maxrequirement',Input::old('maxrequirement'),[
								'class'=>'form-control',
								'placeholder'=>'Enter maximum system requirements here...',
								'data-autoresize',
								'rows' => '2'
							]) }}
						</div>
					</div>
					<div class="form-group">
						<div class=" col-md-offset-6 col-md-3">
							<button type="button" class="btn btn-default btn-block" id="previous">Previous</button>
						</div>
						<div class="col-md-3">
							<button type="submit" class="btn btn-primary btn-block">Create</button>
						</div>
					</div>
				</div>
				{{ Form::close() }}
			</div> <!-- end of modal-body -->
		</div> <!-- end of modal-content -->
	</div>
</div>
<script>
	$('#createSoftwareModal').on('show.bs.modal',function(e){


		$('#next').click(function(){
			$('#page-one').hide(400);
			$('#page-two').show(400);
		});

		$('#previous').click(function(){
			$('#page-two').hide(400);
			$('#page-one').show(400);
		});

		$.ajax({
			type: 'get',
			url: '{{ url("get/software/license/all") }}',
			dataType: 'json',
			success: function(response){
				options = "";
				for(ctr = 0;ctr<response.length;ctr++){
					options +=  `<option value="`+response[ctr]+`">`+response[ctr]+`</option>`;
				}
				$('#licensetype').html("");
				$('#licensetype').append(options);
			}
		});

		$.ajax({
			type: 'get',
			url: '{{ url("get/software/type/all") }}',
			dataType: 'json',
			success: function(response){
				options = "";
				for(ctr = 0;ctr<response.length;ctr++){
					options +=  `<option value="`+response[ctr]+`">`+response[ctr]+`</option>`;
				}
				$('#softwaretype').html("");
				$('#softwaretype').append(options);
			}
		});
	})
</script>