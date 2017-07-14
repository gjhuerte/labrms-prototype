<div class="modal fade" id="transferTicketModal" tabindex="-1" role="dialog" aria-labelledby="transferTicketModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				{{ Form::open(['method'=>'post','route'=>array('ticket.transfer'),'class'=>'form-horizontal']) }}
				<div class="form-group">
					<div class="col-md-12">
					{{ Form::label('Ticket ID') }}
					{{ Form::text('id',null,[
						'class' => 'form-control',
						'id' => 'transfer-id',
						'readonly',
						'style' => 'background-color: white;'
					]) }}
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-12">
					{{ Form::label('Transfer to') }}
					{{ Form::select('transferto',['Loading all users ...'],null,[
						'class' => 'form-control',
						'id' => 'transfer-to'
					]) }}
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-12">
						<button type="submit" class="btn btn-success btn-lg btn-block">Transfer</button>
					</div>
				</div>
				{{ Form::close() }}
			</div> <!-- end of modal-body -->
		</div> <!-- end of modal-content -->
	</div>
</div>
<script>
	$(document).ready(function(){
		$.getJSON("{{ route('account.laboratory.staff.all') }}",function(response){
			options = "";

			for(ctr = 0; ctr < response.data.length; ctr++ )
			{
				options += `<option value="`+response.data[ctr].id+`">`+response.data[ctr].firstname + " " + response.data[ctr].lastname +`</option>"`
			}

			if(response.data.length == 0)
			{
				options = `<option>None</option>`
			}

			$('#transfer-to').html("")
			$('#transfer-to').append(options)
		})
	});
</script>