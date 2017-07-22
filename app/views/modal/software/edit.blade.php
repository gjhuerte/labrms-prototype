<style>
	#edit-page-two 		{
		display:none;
	}
</style>
<div class="modal fade" id="updateSoftwareModal" tabindex="-1" role="dialog" aria-labelledby="updateSoftwareModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>			
				{{ Form::open(['method'=>'put','route'=>array('software.update'),'class'=>'form-horizontal']) }}
				<input type="hidden" name="id" value="" id="edit-id" />
				<div id="edit-page-one">
					<!-- Title -->
					<div class="form-group">
						<div class="col-sm-12">
						{{ Form::label('name','Software Name') }}
						{{ Form::text('name',Input::old('name'),[
							'id' => 'edit-name',
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
							'id' => 'edit-company',
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
							'id' => 'edit-licensetype',
							'class' => 'form-control'
						]) }}
						</div>
					</div>
					<!-- Software types -->
					<div class="form-group">
						<div class="col-sm-12">
						{{ Form::label('softwaretype','Software Type') }}
						{{ Form::select('softwaretype',['Loading all Software Types ...'],Input::old('softwaretype'),[
							'id' => 'edit-softwaretype',
							'class' => 'form-control'
						]) }}
						</div>
					</div>
				</div>
				<div id="edit-page-two">
					<div class="form-group">
						<!-- description -->
						<div class="col-sm-12">
							{{ Form::label('minrequirement','Minimum System Requirements') }}
							{{ Form::textarea('minrequirement',Input::old('minrequirement'),[
								'id' => 'edit-minrequirement',
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
								'id' => 'edit-maxrequirement',
								'class'=>'form-control',
								'placeholder'=>'Enter maximum system requirements here...',
								'data-autoresize',
								'rows' => '2'
							]) }}
						</div>
					</div>
					<div class="form-group">
						<div class=" col-md-offset-6 col-md-3">
							<button type="button" class="btn btn-default btn-block" id="edit-previous">Previous</button>
						</div>
						<div class="col-md-3">
							<button type="submit" class="btn btn-primary btn-block">Update</button>
						</div>
					</div>
				</div>
				{{ Form::close() }}
			</div> <!-- end of modal-body -->
		</div> <!-- end of modal-content -->
	</div>
</div>
<script>
	$('#updateSoftwareModal').on('show.bs.modal',function(e){


		$('#edit-next').click(function(){
			$('#edit-page-one').hide(400);
			$('#edit-page-two').show(400);
		});

		$('#edit-previous').click(function(){
			$('#edit-page-two').hide(400);
			$('#edit-page-one').show(400);
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
				$('#edit-licensetype').html("");
				$('#edit-licensetype').append(options);
			}
		});

		$.ajax({
			type: 'get',
			url: '{{ url("software/license") }}' + '/' + $('#edit-id').val(),
			dataType: 'json',
			success: function(response){
				var usage = response.multipleuse;
				if(usage == 1){
					$('#edit-multiple').prop('checked',true)
				}else{
					$('#edit-multiple').removeProp('checked')
				}

				$('#edit-licensekey').val(response.key)
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
				$('#edit-softwaretype').html("");
				$('#edit-softwaretype').append(options);
			}
		});
	})
</script>