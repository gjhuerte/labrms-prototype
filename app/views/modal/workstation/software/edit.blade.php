{{-- modal --}}
<div class="modal fade updateSoftwareWorkstationModal-sm" id="updateSoftwareWorkstationModal" tabindex="-1" role="dialog" aria-labelledby="installSoftwareWorkstationModalLabel">
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
					'id' => 'update-softwarelicense',
					'class' => 'form-control',
					'placeholder' => 'License Key'
				]) }}
				</div>					
				<div class="form-group">
				<button class="btn btn-block btn-lg btn-primary" type="button" id="modal-update-license">Update</button>
				</div>
			</div> <!-- end of modal-body -->
		</div> <!-- end of modal-content -->
	</div>
</div>
<script>
$('#updateSoftwareWorkstationModal').on('show.bs.modal',function(event){

	pc_id = $(event.relatedTarget).data('pc')
	software_id = $(event.relatedTarget).data('software')
	url = "{{ url('get/software') }}" + '/' + software_id + '/license/all'
	$('#update-softwarelicense').autocomplete({
		source: url,
		"appendTo": "#updateSoftwareWorkstationModal"
	})

	$('#modal-update-license').on('click',function(){
		_url = '{{ url("workstation/software/$workstation->id/license/update") }}'

		$.post(_url,{'software':software_id,'softwarelicense':$('#update-softwarelicense').val()},function(response){
			if(response == 'success') {
				swal('Operation Success','','success')
			} else {
				swal('Error occurred while processing your data','','error')
			}
			$('#updateSoftwareWorkstationModal').modal('hide')

		},'json')
	})

})
</script>