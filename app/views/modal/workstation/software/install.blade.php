{{-- modal --}}
<div class="modal fade installSoftwareWorkstationModal-sm" id="installSoftwareWorkstationModal" tabindex="-1" role="dialog" aria-labelledby="installSoftwareWorkstationModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title text-muted" id="gridSystemModalLabel">Software License Information</h4>
		      </div>
			<div class="modal-body">
				<div class="form-group">
				{{ Form::label('Software License Key (Optional)') }}
				{{ Form::text('softwarelicense',null,[
					'id' => 'softwarelicense',
					'class' => 'form-control',
					'placeholder' => 'License Key'
				]) }}
				</div>					
				<div class="form-group">
				<button class="btn btn-block btn-lg btn-primary" type="button" id="modal-deploy">Install</button>
				</div>
			</div> <!-- end of modal-body -->
		</div> <!-- end of modal-content -->
	</div>
</div>
<script>
$('#installSoftwareWorkstationModal').on('show.bs.modal',function(event){

	pc_id = $(event.relatedTarget).data('pc')
	software_id = $(event.relatedTarget).data('software')
	url = "{{ url('get/software') }}" + '/' + software_id + '/license/all'
	$('#softwarelicense').autocomplete({
		source: url,
		"appendTo": "#installSoftwareWorkstationModal"
	})

	$('#modal-deploy').on('click',function(){
		_url = '{{ url("workstation/software/$workstation->id/assign") }}'

		$.post(_url,{'software':software_id,'softwarelicense':$('#softwarelicense').val()},function(response){
			if(response == 'success') {
				swal('Operation Success','','success')
			} else {
				swal('Error occurred while processing your data','','error')
			}

			$('#installSoftwareWorkstationModal').modal('hide')

		},'json')
	})

})
</script>