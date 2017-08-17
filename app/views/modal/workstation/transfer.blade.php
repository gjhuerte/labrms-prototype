{{-- modal --}}
<div class="modal fade" id="transferWorkstationModal" tabindex="-1" role="dialog" aria-labelledby="transferWorkstationModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<div class="form-group" style="margin-top: 20px;">
				{{ Form::label('Selected Items') }}
				{{ Form::text('items',null,[
					'id' => 'transfer-items',
					'class' => 'form-control',
					'readonly',
					'style' => 'background-color:white;'
				]) }}
				</div>				
				<div class="form-group">
				{{ Form::label('Location') }}
				{{ Form::select('room',['Loading All Rooms'],null,[
					'id' => 'transfer-room',
					'class' => 'form-control'
				]) }}
				</div>				
				<div class="form-group">
				<button class="btn btn-block btn-lg btn-primary" data-loading-text="Loading..." type="button" id="modal-transfer">Transfer</button>
				</div>
			</div> <!-- end of modal-body -->
		</div> <!-- end of modal-content -->
	</div>
</div>
<script>
$('#transferWorkstationModal').on('show.bs.modal',function(){
	console.log($('#selected').val())
	$('#transfer-items').text($('#selected').val())
	$('#transfer-items').val($('#selected').val())

	$.getJSON("{{ route('room.index') }}",function(response){
		options = "";
		for(ctr = 0;ctr<response.data.length;ctr++){
			options += `<option value='`+response.data[ctr].name+`'>`+response.data[ctr].name+`</option>'`;
		}

		$('#transfer-room').html("");
		$('#transfer-room').append(options);
		$('#transfer-room').val('Server');
	})

})
</script>