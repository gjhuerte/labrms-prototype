<div class="modal fade" id="resolveTicketModal" tabindex="-1" role="dialog" aria-labelledby="resolveTicketModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
			@if (count($errors) > 0)
				<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<ul style='margin-left: 10px;'>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
					</ul>
				</div>
			@endif
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 style="color:#337ab7;">Action|Solution Taken</h3>
			</div>
			<div class="modal-body">
			{{ Form::open(['method'=>'post','route'=>'ticket.resolve','class'=>'form-horizontal','id'=>'ticketForm']) }}
				<input type="hidden" value="" name="id" id="resolve-id" />
				<div class="form-group">
					<div class="col-sm-12">
						{{ Form::label('Staff') }}
						{{ Form::text('author',Auth::user()->firstname . " " . Auth::user()->lastname,[
							'class' => 'form-control',
							'readonly',
							'style' => 'border:none;'
						]) }}
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
						{{ Form::label('Remarks / Details') }}
						{{ Form::textarea('details',Input::old('details'),[
							'class' => 'form-control'
						]) }}
						<p class="text-muted">Action taken to resolve the issue</p>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
						<input type="checkbox" name="underrepair" />
						<label for="">Set as 'For Repair' or 'Undermaintenance'</label> 
						<p class="text-muted">Clicking this checkbox will set the item/equipment/pc as 'for repair' or 'undermaintenance' for room status.</p>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
						<input type="checkbox" name="close" />
						<label for="">Close Ticket?</label> 
						<p class="text-muted">This will close the ticket. The Administrator can reopen the ticket if he/she is not satisfied with the result</p>
					</div>
				</div>	
				<div class="form-group">
					<div class="col-sm-12">
						{{ Form::submit('Okay',[
						'class'=>'btn btn-block btn-flat pull-right btn-md btn-primary',
						'style'=>'padding: 10px'
						]) }}
					</div>
				</div>
			{{ Form::close() }}
			</div> <!-- end of modal-body -->
		</div> <!-- end of modal-content -->
	</div>
</div>
