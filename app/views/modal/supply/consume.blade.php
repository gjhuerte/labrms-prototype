{{ HTML::style(asset('css/animate.css')) }}
<div class="modal fade" id="consumeSuppliesModal" tabindex="-1" role="dialog" aria-labelledby="consumeSuppliesModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				{{ Form::open(['method'=>'delete','route'=>array('supplies.destroy'), 'class' => 'form-horizontal']) }}
				<input type="hidden" id="consume-id" name="id" />
				<div class="form-group">
					<div class="col-md-12">
					{{ Form::label('Accessor') }}
					{{ Form::text('name',null,[
						'class' => 'form-control',
						'placeholder' => 'Accessors Name'
					]) }}
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-12" id="quantity-field">
					{{ Form::label('Quantity') }}
					{{ Form::number('quantity',null,[
						'id' => 'quantity',
						'class' => 'form-control',
						'placeholder' => 'Quantity to Consume'
					]) }}
					<p class="text-danger" id="error-quantity" style="display:none;">Quantity inputted must not be greater than total supplies</p>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-12">
					{{ Form::label('Remark') }}
					{{ Form::textarea('purpose',null,[
						'class' => 'form-control',
						'placeholder' => 'Additional Remarks'
					]) }}
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-12">
						<button class="btn btn-primary btn-lg btn-block" type="submit">Release</button>
					</div>
				</div>
				{{ Form::close() }}
				<input type="hidden" id="consume-quantity" />
			</div> <!-- end of modal-body -->
		</div> <!-- end of modal-content -->
	</div>
</div>
<script>
$('#quantity').on('change keyup',function(){
	var x = parseInt($('#consume-quantity').val())
	var quantity = parseInt($('#quantity').val())
	if(quantity > x)
	{
		$('#quantity').val(x)
		$('#error-quantity').show(400)
	}else{
		$('#error-quantity').hide(400)
	}
})

$.fn.extend({
    animateCSS: function (animationName) {
        var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
        this.addClass('animated ' + animationName).one(animationEnd, function() {
            $(this).removeClass('animated ' + animationName);
        });
    }
});
</script>