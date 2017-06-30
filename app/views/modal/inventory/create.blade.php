<style>
	#create-inventory{
		display:none;
	}

	#create-podate,#create-invoicedate{
		background-color:white;
	}

</style>
{{ HTML::style(asset('css/jquery-ui.min.css')) }}
{{ HTML::script(asset('js/moment.min.js')) }}
{{ HTML::script(asset('js/jquery-ui.js')) }}
<div class="modal fade" id="createInventoryModal" tabindex="-1" role="dialog" aria-labelledby="createInventoryModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ Form::open(['method'=>'post','route'=>'inventory.item.store','class'=>'form-horizontal','id'=>'inventoryForm']) }}
			<ul class="breadcrumb">
				<li><a href="{{ url('inventory/item') }}">Inventory</a></li>
				<li><a href="{{ url('inventory/item') }}">Item</a></li>
				<li class="active">Create</li>
			</ul>
	 		<div id="create-receipt">
				<legend><h3 style="color:#create-337ab7;">Receipt</h3></legend>
					<!-- item name -->
					<div class="form-group">
						<div class="col-sm-12">
						{{ Form::label('number','Acknowledgement Receipt ( M.R., P.A.R. )') }}
						{{ Form::text('number',Input::old('number'),[
							'class' => 'form-control',
							'placeholder' => 'Acknowledgement Receipt',
							'id' => 'create-number'
						]) }}
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
						{{ Form::label('ponumber','P.O. Number') }}
						{{ Form::number('ponumber',Input::old('ponumber'),[
							'class' => 'form-control',
							'placeholder' => 'P.O. Number',
							'id' => 'create-ponumber'
						]) }}
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
						{{ Form::label('podate','P.O. Date') }}
						{{ Form::text('podate',Input::old('podate'),[
							'class' => 'form-control',
							'placeholder' => 'P.O. Date',
							'id' => 'create-podate',
							'readonly'
						]) }}
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
						{{ Form::label('invoicenumber','Invoice Number') }}
						{{ Form::number('invoicenumber',Input::old('invoicenumber'),[
							'class' => 'form-control',
							'placeholder' => 'P.O. Number',
							'id' => 'create-ponumber'
						]) }}
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
						{{ Form::label('invoicedate','Invoice Date') }}
						{{ Form::text('invoicedate',Input::old('invoicedate'),[
							'class' => 'form-control',
							'placeholder' => 'Invoice Date',
							'id' => 'create-invoicedate',
							'readonly'
						]) }}
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
						{{ Form::label('fundcode','Fund Code') }}
						{{ Form::text('fundcode',Input::old('fundcode'),[
							'class' => 'form-control',
							'placeholder' => 'Fund Code',
							'id' => 'create-fundcode'
						]) }}
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-8 col-sm-4">
							<button name="next" id="create-link-to-inventory" class="btn btn-primary btn-flat btn-block" type="button">Next <span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span></button>
						</div>
					</div>
	 		</div>
	 		<div id="create-inventory">
				<legend><h3 style="color:#create-337ab7;">Inventory</h3></legend>
				<div id="create-page-one">
					<!-- item name -->
					<div class="form-group">
						<div class="col-sm-12">
						{{ Form::label('brand','Brand') }}
						{{ Form::text('brand',Input::old('brand'),[
							'class' => 'form-control',
							'placeholder' => 'Brand',
							'id' => 'create-brand'
						]) }}
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
						{{ Form::label('model','Model') }}
						{{ Form::text('model',Input::old('model'),[
							'class' => 'form-control',
							'placeholder' => 'Model',
							'id' => 'create-model'
						]) }}
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
						{{ Form::label('itemtype','Type') }}
						{{ Form::select('itemtype',['Fetching all item types...'],Input::old('itemtype'),[
							'class' => 'form-control',
							'placeholder' => 'Item type',
							'id' => 'create-itemtype'
						]) }}
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
						{{ Form::label('details','Item Details') }}
						{{ Form::textarea('details',Input::old('details'),[
							'class' => 'form-control',
							'placeholder' => 'Item Details',
							'id' => 'create-details'
						]) }}
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-4 col-sm-4">
							<button name="previous" id="create-link-to-receipt" class="btn btn-default btn-block" type="button"> <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Previous</button>
						</div>
						<div class="col-sm-4">
							<button name="next" id="create-next" class="btn btn-primary btn-block" type="button">Next <span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span></button>
						</div>
					</div>
				</div>
				<div id="create-page-two">
					<div class="form-group">
						<div class="col-sm-12">
						{{ Form::label('unit','Unit') }}
						{{ Form::text('unit',Input::old('unit'),[
							'class' => 'form-control',
							'placeholder' => 'Unit'
						]) }}
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
						{{ Form::label('quantity','Quantity') }}
						{{ Form::number('quantity',Input::old('quantity'),[
							'class' => 'form-control',
							'placeholder' => 'Quantity'
						]) }}
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
						{{ Form::label('warranty','Warranty Information') }}
						{{ Form::textarea('warranty',Input::old('warranty'),[
							'class' => 'form-control',
							'placeholder' => 'Warranty Information',
							'id' => 'create-warranty'
						]) }}
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-4 col-sm-4">
							<button name="previous" id="create-previous" class="btn btn-default btn-flat btn-block" type="button"> <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Previous</button>
						</div>
						<div class="col-sm-4">
							<button type="submit" value="create" name="action" id="create-submit" class="btn btn-primary btn-flat btn-block"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Submit </button>
						</div>
					</div>
				</div>
			</div>
			{{ Form::close() }}
			</div> <!-- end of modal-body -->
		</div> <!-- end of modal-content -->
	</div>
</div>
<script>
		$('#create-link-to-inventory').click(function(){
			$('#create-page-two').hide(600);
			$('#create-receipt').hide(600);
			$('#create-inventory').show();
			$('#create-page-one').show(600);
		});

		$('#create-link-to-receipt').click(function(){
			$('#create-inventory').hide(600);
			$('#create-receipt').show(600);
		});

		$('#create-next').click(function(){
			$('#create-page-one').hide(600);
			$('#create-page-two').show(600);
		});

		$('#create-previous').click(function(){
			$('#create-page-two').hide(600);
			$('#create-page-one').show(600);
		});

		$( "#create-podate" ).datepicker({
			  changeMonth: true,
			  changeYear: false,
			  maxAge: 59,
			  minAge: 15,
		});

		$( "#create-invoicedate" ).datepicker({
			  changeMonth: true,
			  changeYear: false,
			  maxAge: 59,
			  minAge: 15,
		});

		init();

		function init(){
			$.ajax({
				type: "get",
				url: "{{ url('item/type/') }}",
				dataType: 'json',
				success: function(response){
					var options = "";

					for(var ctr = 0;ctr < response.data.length;ctr++)
					{
						options += `<option value="`+response.data[ctr].id+`">
							`+response.data[ctr].name+`
						</option>`;
					}

					$('#create-itemtype').html("");
					$('#create-itemtype').append(options);
				}
			})
		}

		$('#create-podate').val({{ "'".Carbon\Carbon::now()->toFormattedDateString()."'" }});
		setDate("#create-podate");

		$('#create-podate').on('change',function(){
			setDate("#create-podate");
		});

		$('#create-invoicedate').val({{ "'".Carbon\Carbon::now()->toFormattedDateString()."'" }});
		setDate("#create-invoicedate");

		$('#create-invoicedate').on('change',function(){
			setDate("#create-invoicedate");
		});

		function setDate(object){
				var object_val = $(object).val()
				var date = moment(object_val).format('MMM DD, YYYY');
				$(object).val(date);
		}
</script>