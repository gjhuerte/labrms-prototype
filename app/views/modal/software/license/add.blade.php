<div class="modal fade" id="addSoftwareLicenseModal" tabindex="-1" role="dialog" aria-labelledby="addSoftwareLicenseModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>			
				<legend><h3 class="text-muted">{{ $software->softwarename }}</h3></legend>
				{{ Form::open(['method'=>'post','url'=>'software/license','class'=>'form-horizontal']) }}
				<input type="hidden" name="id" value="{{ $software->id }}" />
				<div class="form-group">
					<div class="col-md-12">
					{{ Form::label('license','License Key') }}
					{{ Form::text('licensekey',Input::old('licensekey'),[
						'class' => 'form-control'
					]) }}
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-12">
					{{ Form::label('usage','Usage Amount') }}
					{{ Form::number('usage',Input::old('usage'),[
						'class' => 'form-control'
					]) }}
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-12">
						<button class="btn btn-md btn-primary btn-block">Submit</button>
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
			$('#page-to').show(400);
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