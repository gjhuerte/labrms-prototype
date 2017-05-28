
{{ HTML::style(asset('css/jquery-ui.min.css')) }}
{{ HTML::script(asset('js/jquery-ui.js')) }}
<style>
	#podate,#invoicedate{
		background-color:white;
	}
</style>
<div class="modal fade" id="inventoryAdd" tabindex="-1" role="dialog" aria-labelledby="generateTicketModal">
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
				<h3 style="color:#337ab7;">Inventory</h3>
			</div>
			<div class="modal-body" style="padding-bottom: 0px;">
        <div class="panel panel-default" style="border:none;margin-bottom:0;padding-bottom: 0px;padding-left: 20px;padding-right:20px;">
          {{ Form::open(['method'=>'post','route'=>'inventory.item.store','class'=>'form-horizontal']) }}
          <div class="panel-body">
            <div class="form-group">
              <label>Model</label>
              <span id="id-span" class="form-control"></span>
              <input type="hidden" name="id" value="" id="id"/>
            </div>
            <div class="form-group">
              {{ Form::label('number','Receipt details ( M.R., Acknowledgement )') }}
              {{ Form::text('number',Input::old('receipt'),[
                  'class' => 'form-control'
                ]) }}
            </div>
            <div class="form-group">
              {{ Form::label('quantity','Quantity') }}
              {{ Form::number('quantity',Input::old('quantity'),[
                  'class' => 'form-control'
                ]) }}
            </div>
						<div class="form-group">
							{{ Form::label('ponumber','P.O. Number') }}
							{{ Form::number('ponumber',Input::old('ponumber'),[
								'class' => 'form-control',
								'placeholder' => 'P.O. Number',
								'id' => 'ponumber'
							]) }}
						</div>
						<div class="form-group">
							{{ Form::label('podate','P.O. Date') }}
							{{ Form::text('podate',Input::old('podate'),[
								'class' => 'form-control',
								'placeholder' => 'P.O. Date',
								'id' => 'podate',
								'readonly'
							]) }}
						</div>
						<div class="form-group">
							{{ Form::label('invoicenumber','Invoice Number') }}
							{{ Form::number('invoicenumber',Input::old('invoicenumber'),[
								'class' => 'form-control',
								'placeholder' => 'P.O. Number',
								'id' => 'ponumber'
							]) }}
						</div>
						<div class="form-group">
							{{ Form::label('invoicedate','Invoice Date') }}
							{{ Form::text('invoicedate',Input::old('invoicedate'),[
								'class' => 'form-control',
								'placeholder' => 'Invoice Date',
								'id' => 'invoicedate',
								'readonly'
							]) }}
						</div>
						<div class="form-group">
							{{ Form::label('fundcode','Fund Code') }}
							{{ Form::text('fundcode',Input::old('fundcode'),[
								'class' => 'form-control',
								'placeholder' => 'Fund Code',
								'id' => 'fundcode'
							]) }}
						</div>
            <div class="form-group">
              <button type="submit" class="btn btn-success btn-block btn-lg" name='action' value='add'>Add</button>
            </div>
          </div>
        </div>
			</div> <!-- end of modal-body -->
      <div class="modal-footer">
        <p class='text-muted text-center'>CCIS - LOO &copy; 2017</p>
      </div>
		</div> <!-- end of modal-content -->
	</div>
</div>
<script>
  $(document).ready(function(){
    $('.add').on('click',function(){
      $('#id-span').text($(this).data('model'));
      $('#id').val($(this).data('id'));
    })

		$( "#podate" ).datepicker({
			  changeMonth: true,
			  changeYear: false,
			  maxAge: 59,
			  minAge: 15,
		});

		$( "#invoicedate" ).datepicker({
			  changeMonth: true,
			  changeYear: false,
			  maxAge: 59,
			  minAge: 15,
		});
  })

</script>
