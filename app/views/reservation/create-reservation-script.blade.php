
@section('script')
{{ HTML::script(asset('js/bootstrap-tagsinput.min.js')) }}
{{ HTML::script(asset('js/moment.min.js')) }}
<script type="text/javascript" src="{{ asset('js/standalone/selectize.js') }}"></script>
<script>
	$(document).ready(function(){

		$('#dateofuse').on('change',function(){
			$('#dateofuse').val(moment($('#dateofuse').val()).format('MMMM DD, YYYY'))
		});

		$('#item-list-adder').on('click',function(){
			$('#itemAddModal').modal('hide')
			if($('#propertynumber').val()){
				$('#items').tagsinput('add',$('#propertynumber').val());
			}
		})

		$('#itemAddModal').on('show.bs.modal', function (e) {
			$.ajax({
				url: '{{ url("get/reservation/item/type/all") }}',
				type: 'get',
				dataType: 'json',
				success: function(response){
					options = '';

					for(ctr = 0;ctr< response.length;ctr++){
						options += "<option value='"+response[ctr].name+"'>"+response[ctr].name+"</option>"
					}

					if(response.length == 0)
					{
						options = "<option value='null'>No propertynumber found</option>";
					}

					$('#itemtype').html("")
					$('#itemtype').append(options)
				},
				error: function(){
					$('#itemtype').html("")
					$('#itemtype').append("<option value='null'>No item type found</option>")
				},
				complete: function(){
					itembrand();
				}
			})
		})

		function itembrand()
		{
				$.ajax({
					url: '{{ url('get/reservation/item/brand/all') }}',
					type: 'get',
					data:{
						'itemtype': $('#itemtype').val()
					},
					dataType: 'json',
					success: function(response){
						options = '';

						for(ctr = 0;ctr< response.length;ctr++){
							options += "<option value='"+response[ctr].brand+"'>"+response[ctr].brand+"</option>"
						}

						if(response.length == 0)
						{
							options = "<option value='null'>No propertynumber found</option>";
						}

						$('#itembrand').html("")
						$('#itembrand').append(options)
					},
					error: function(){
						$('#itembrand').html("")
						$('#itembrand').append("<option value='null'>No item brand found</option>")
					},
					complete: function(){
						itemmodel();
					}
				})
		}

		function itemmodel()
		{
				$.ajax({
					url: '{{ url('get/reservation/item/model/all') }}',
					type: 'get',
					data:{
						'brand': $('#itembrand').val()
					},
					dataType: 'json',
					success: function(response){
						options = '';

						for(ctr = 0;ctr< response.length;ctr++){
							options += "<option value='"+response[ctr].model+"'>"+response[ctr].model+"</option>"
						}

						if(response.length == 0)
						{
							options = "<option value='null'>No item model found</option>";
						}

						$('#itemmodel').html("")
						$('#itemmodel').append(options)
					},
					error: function(){
						$('#itemmodel').html("")
						$('#itemmodel').append("<option value='null'>No item model found</option>")
					},
					complete: function(){
						propertynumber();
					}
				})
		}

		$('#itemtype').on('change',function(){
			itembrand();
		})

		$('#itembrand').on('change',function(){
			itemmodel();
		});

		$('#itemmodel').on('change',function(){
			propertynumber();
		})

		function propertynumber()
		{
				$.ajax({
					url: '{{ url("get/reservation/item/propertynumber/all") }}',
					type: 'get',
					data: {
						'itemtype': $('#itemtype').val(),
						'brand': $('#itembrand').val(),
						'model': $('#itemmodel').val()
					},
					dataType: 'json',
					success: function(response){
						options = '';
						for(ctr = 0;ctr< response.length ;ctr++){
							options += "<option value='"+response[ctr].propertynumber+"'>"+response[ctr].propertynumber+"</option>"
						}

						if(response.length == 0)
						{
							options = "<option value='null'>No property number found</option>";
						}
						$('#propertynumber').html("")
						$('#propertynumber').append(options)
					},
					error: function(response){
						$('#propertynumber').html("")
						$('#propertynumber').append("<option value='null'>No property number found</option>")
					}
				})
		}


		@if( Session::has("success-message") )
		  swal("Success!","{{ Session::pull('success-message') }}","success");
		@endif
		@if( Session::has("error-message") )
		  swal("Oops...","{{ Session::pull('error-message') }}","error");
		@endif

		$('#show').click(function(){
			$('#reservationCalendarModal').modal('show');
		});

		$('#show-notes').click(function(){
				$('#reservation-info').show();
				$('#hide-notes').show();
				$('#show-notes').hide();
		});

		$('#hide-notes').click(function(){
				$('#reservation-info').hide();
				$('#hide-notes').hide();
				$('#show-notes').show();
		});

		$(function() {
			$( "#dateofuse" ).datepicker({
			  changeMonth: true,
			  changeYear: false,
			  maxAge: 59,
			  minAge: 15,
			});
		});

		$(document).ready(function(){
			$("#dateofuse").val('{{ Carbon\Carbon::now()->toFormattedDateString() }}');
		});

		$('#starttime').timepicker({
			timeFormat: 'h:mm p',
			interval: 30,
			minTime: '7',
			maxTime: '7:00pm',
			defaultTime: '7:00am',
			startTime: '7:00am',
			dynamic: false,
			dropdown: true,
			scrollbar: true
		});

		$('#endtime').timepicker({
		    timeFormat: 'h:mm p',
		    interval: 30,
		    minTime: '8',
		    maxTime: '9:00pm',
		    defaultTime: '8:00am',
		    startTime: '8:00am',
		    dynamic: false,
		    dropdown: true,
		    scrollbar: true
		});

		$('#request').click(function(){
			swal({
			  title: "Are you sure?",
			  text: "By submitting a request, you acknowledge our condition of three(3) working days in item reservation unless there is a special event or non-working holidays. Disregarding this notice decreases your chance of approval",
			  type: "warning",
			  showCancelButton: true,
			  confirmButtonColor: "#DD6B55",
			  confirmButtonText: "Yes, submit it!",
			  cancelButtonText: "No, cancel it!",
			  closeOnConfirm: false,
			  closeOnCancel: false
			},
			function(isConfirm){
			  if (isConfirm) {
					$("#reservationForm").submit();
			  } else {
			    swal("Cancelled", "Request Cancelled", "error");
			  }
			});
		});

		init();

		function init(){
      $.ajax({
        type: 'get',
        url: "{{ route('room.index') }}",
        dataType: 'json',
        success: function(response){
          items = "";
          for(ctr = 0;ctr<response.length;ctr++){
            items += `<option value=`+response[ctr].name+`>
            `+response[ctr].name+`
            </option>`;
          }

          if(response.length == 0){
              items += `<option>There are no available room</option>`
          }

          $('#location').html("");
          $('#location').append(items);
        },
				complete: function(){

					$('#location').selectize({
							create: true,
							sortField: {
									field: 'text',
									direction: 'asc'
							},
							dropdownParent: 'body'
					})

					$('#location').val({{ Input::old('location') }})
				}
      });
	      $.ajax({
	        type: 'get',
	        url: "{{ route('faculty.index') }}",
	        dataType: 'json',
	        success: function(response){
	          items = "";
	          for(ctr = 0;ctr<response.length;ctr++){
							lastname = response[ctr].lastname;
							firstname = response[ctr].firstname;
							if(response[ctr].middlename){
								middlename = response[ctr].middlename;
							}else{
								middlename = "";
							}
	            items += `<option value=`+response[ctr].id+`>
	            `+lastname+', '+firstname+' '+middlename+`
	            </option>`;
	          }

	          if(response.length == 0){
	              items += `<option>There are no available faculty</option>`
	          }

	          $('#name').html("");
	          $('#name').append(items);
	        },
					complete: function(){

						$('#name').selectize({
								create: true,
								sortField: {
										field: 'text',
										direction: 'asc'
								},
								dropdownParent: 'body'
						})

						$('#name').val({{ Input::old('name') }})
					}
	      });
		}


		$('#page-body').show();

	});
</script>
@stop
