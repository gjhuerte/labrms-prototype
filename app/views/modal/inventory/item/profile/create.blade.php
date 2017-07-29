<div class="modal fade" id="createItemProfileModal" tabindex="-1" role="dialog" aria-labelledby="createItemProfileModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

				{{ Form::open(['method'=>'post','route'=>'item.profile.store','class'=>'form-horizontal','id'=>'profilingForm']) }}
				<!-- item name -->
				<div class="form-group">
					<div class="col-sm-12">
						<label for="inventory_id">
							Inventory ID
						</label>
						{{ Form::text('inventory_id',null,[
							'class' => 'form-control',
							'id' => 'inventory_id',
							'placeholder' => 'Inventory ID',
							'readonly',
							'style'=>'background-color:white;'
						]) }}
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
					{{ Form::label('receipt_id','Acknowledgement Receipt') }}
					{{ Form::select('receipt_id',['List empty'],Input::old('receipt_id'),[
						'class' => 'form-control readonly-white',
						'placeholder' => 'Information ID',
						'readonly',
						'style'=>'background-color:white;'
					]) }}
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
					{{ Form::label('propertyid','Property Number') }}
					{{ Form::text('propertyid',Input::old('propertyid'),[
						'class' => 'form-control',
						'placeholder' => 'Property Number'
					]) }}
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
					{{ Form::label('serialid','Serial Number') }}
					{{ Form::text('serialid',Input::old('serialid'),[
						'class' => 'form-control',
						'placeholder' => 'Serial Number'
					]) }}
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
					{{ Form::label('date','Date Received') }}
					<input id="dateReceived" class="form-control" placeholder="Date Received" readonly="readonly" name="datereceived" type="text" style="background-color: white;">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
					{{ Form::label('location','Location') }}
					{{ Form::select('location',['Loading all locations ..'],Input::old('location'),[
						'id' => 'location',
						'class' => 'form-control',
						'placeholder' => 'Location'
					]) }}
					<p class="text-muted pull-right" style="font-size:10px;"><span class="text-danger">Note:</span> The Default Storage Location is <strong>Server Room</strong></p>
					</div>
				</div>
				<div class="form-group">
						<div class="col-md-12">
						{{ Form::submit('Profile',[
							'class'=> 'btn btn-lg btn-flat btn-primary btn-block',
							'name' => 'Profile'
						]) }}
						</div>
				</div>
				{{ Form::close() }}
			</div> <!-- end of modal-body -->
		</div> <!-- end of modal-content -->
	</div>
</div>
<script>
	$('#createItemProfileModal').on('show.bs.modal',function(){

		$.ajax({
			type: 'get',
			url: '{{ route("item.profile.receipt.all") }}',
			data: { 'id' : $('#inventory_id').val() },
			dataType: 'json',
			success: function(response){
				var options = '';

				for( ctr = 0 ; ctr < response.length ; ctr++ ){
					options += `<option value=`+response[ctr].id+`>`+response[ctr].number+`</option>`;
				}

				$('#receipt_id').html('');
				$('#receipt_id').append(options);
			},
			error: function(response){
				swal('Oops...','Error ocurred while fetching data','error');
				console.log(response.responseJSON)
			}
		});

		$.ajax({
			type : "get",
			url : "{{ route('room.index') }}",
			dataType : "json",
			success : function(response){
				options = "";
				for(ctr = 0;ctr<response.data.length;ctr++){
					options += `<option value='`+response.data[ctr].name+`'>`+response.data[ctr].name+`</option>'`;
				}

				$('#location').html("");
				$('#location').append(options);
			},
			error : function(response){
				$('#location').html("<option>Loading all locations ...</option>")
				console.log(response.responseJSON);
			},
			complete: function(response){
				$('#location').val('Server');
			}
		});

		$( "#dateReceived" ).datepicker({
			  changeMonth: true,
			  changeYear: false,
			  maxAge: 59,
			  minAge: 15,
		});

		$('#dateReceived').val({{ "'".Carbon\Carbon::now()->toFormattedDateString()."'" }});
		setDate("#dateReceived");

		$('#dateReceived').on('change',function(){
			setDate("#dateReceived");
		});

		function setDate(object){
				var object_val = $(object).val()
				var date = moment(object_val).format('MMM DD, YYYY');
				$(object).val(date);
		}

		$.ajax({
			type: 'get',
			url: '{{ url("inventory/item") }}' + '/' + $('#inventory_id').val(),
			dataType: 'json',
			success: function(response){
				$('#total').text(response.quantity - response.profileditems);
			}
		})
	})
</script>