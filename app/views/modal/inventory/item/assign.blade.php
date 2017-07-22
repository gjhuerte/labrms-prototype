<div class="modal fade" id="assignModal" tabindex="-1" role="dialog" aria-labelledby="createActivityModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				{{ Form::open() }}
					<div style="margin-top:20px;margin-bottom:20px;">
						<div class="form-group">
						{{ Form::label('Selected Items') }}
						{{ Form::text('item',null,[
							'id' => 'assign-item',
							'class' => 'form-control'
						]) }}
						</div>
						<div class="form-group">
						{{ Form::label('Room') }}
						{{ Form::select('room',['Loading all rooms'],null,[
							'id' => 'location',
							'class' => 'form-control'
						]) }}
						</div>
						<button class="btn btn-primary btn-lg btn-block">Assign</button>
					</div>
				{{ Form::close() }}
			</div> <!-- end of modal-body -->
		</div> <!-- end of modal-content -->
	</div>
</div>
<script>
$('#assignModal').on('show.bs.modal',function(){
	$.getJSON('{{ url("room") }}',function(response){
		options = "";
		for(ctr = 0;ctr<response.data.length;ctr++){
			options += `<option value='`+response.data[ctr].name+`'>`+response.data[ctr].name+`</option>'`;
		}

		$('#location').html("");
		$('#location').append(options);
	})
})
</script>