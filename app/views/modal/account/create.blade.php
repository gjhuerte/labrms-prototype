<div class="modal fade" id="createNewAccountModal" tabindex="-1" role="dialog" aria-labelledby="createNewAccountModal">
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
        <h3 style="color:#337ab7;">Create New Account</h3>
      </div>
      <div class="modal-body">
          {{ Form::open([
            'class' =>'form-horizontal',
            'id'=>'registrationForm',
            'route'=>'account.store'
          ]) }}
          <div class="form-group">
            <div class="col-md-12">
            {{ Form::label('username','Identification Number') }}
            {{ Form::text('username',Input::old('username'),[
                'class' => 'form-control',
                'id' => 'username',
                'placeholder' => 'Identification Number'
            ])}}
            <p class="text-muted" style="font-size: 10px;"><span class="text-success">Note:</span>The Identification Number will be used as the username of the said person.</p>
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-12">
            {{ Form::label('password','Password') }}
            {{ Form::password('password',[
                'class' => 'form-control',
                'id' => 'password',
                'placeholder' => 'Password'
            ]) }}
            <p class="text-danger" style="font-size: 10px;"><span class="text-success">Note:</span>This field must be atleast eight(8) characters.</p>
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-12">
            {{ Form::label('confirm','Confirm Password') }}
            {{ Form::password('confirm',[
                'class' => 'form-control',
                'id' => 'confirm',
                'placeholder' => 'Confirm Password'
            ]) }}
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-12">
            {{ Form::label('firstname','Firstname') }}
            {{ Form::text('firstname',Input::old('firstname'),[
                'class' => 'form-control',
                'id' => 'firstname',
                'placeholder' => 'First name'
              ]) }}
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-12">
            {{ Form::label('middlename','Middlename') }}
            {{  Form::text('middlename',Input::old('middlename'),[
                  'class' => 'form-control',
                  'id' => 'middlename',
                  'placeholder' => 'Middle name'
                ])}}
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-12">
            {{ Form::label('lastname','Lastname') }}
             {{ Form::text('lastname',Input::old('lastname'),[
                'class' => 'form-control',
                'id' => 'lastname',
                'placeholder' => 'Last name'
             ]) }}
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-12">
            {{ Form::label('contactnumber','Mobile Number') }}
            {{ Form::text('contactnumber',Input::old('contactnumber'),[
                'class' => 'form-control',
                'id' => 'contactnumber',
                'placeholder' => 'Mobile Number'
            ]) }}
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-12">
            {{ Form::label('email','Email') }}
            {{ Form::text('email',Input::old('email'),[
                'class' => 'form-control',
                'id' => 'email',
                'placeholder' => 'Email'
            ]) }}
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-12">
            {{ Form::label('type','Role') }}
            {{ Form::select('type',[
              'assistant'=>'Laboratory Assistant',
              'staff'=>'Staff',
              'faculty'=>'Faculty',
              'student'=>'Student'
            ],Input::old('type'),[
              'class'=>'form-control'
            ]) }}
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-12">
              <button class="btn btn-lg btn-primary btn-block" id="register" type="submit" value="Create"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Create</button>
            </div>
          </div>
          {{ Form::close() }}
      </div> <!-- end of modal-body -->
    </div> <!-- end of modal-content -->
  </div>
</div>
<script type="text/javascript" src="{{ asset('js/jquery.validate.min.js') }}"></script>
<script>
  $(document).ready(function(){


    $( "#registrationForm" ).validate( {
      rules: {
        firstname: "required",
        lastname: "required",
        username: {
          required: true,
          minlength: 4
        },
        password: {
          required: true,
          minlength: 8
        },
        confirm: {
          required: true,
          minlength: 8,
          equalTo: "#password"
        },
        contactnumber: {
          required: true,
          minlength: 11,
          maxlength: 11
        },
        email: {
          required: true,
          email: true
        }
      },
      messages: {
        firstname: "Please enter your firstname",
        lastname: "Please enter your lastname",
        username: {
          required: "Please enter a username",
          minlength: "Your username must consist of at least 4 characters"
        },
        password: {
          required: "Please provide a password",
          minlength: "Your password must be at least 8 characters long"
        },
        confirm: {
          required: "Please provide a password",
          minlength: "Your password must be at least 8 characters long",
          equalTo: "Please enter the same password as above"
        },
        contactnumber: {
          required: "Please provide your contact number",
          minlength: "Contact Number must be 11-digit",
          minlength: "Contact Number must be 11-digit"
        },
        email: "Please enter a valid email address"
      },
      errorElement: "em",
      errorPlacement: function ( error, element ) {
        // Add the `help-block` class to the error element
        error.addClass( "help-block" );

        // Add `has-feedback` class to the parent div.form-group
        // in order to add icons to inputs
        element.parents( ".form-group" ).addClass( "has-feedback" );

        if ( element.prop( "type" ) === "checkbox" ) {
          error.insertAfter( element.parent( "label" ) );
        } else {
          error.insertAfter( element );
        }

        // Add the span element, if doesn't exists, and apply the icon classes to it.
        if ( !element.next( "span" )[ 0 ] ) {
          $( "<span class='glyphicon glyphicon-remove form-control-feedback'></span>" ).insertAfter( element );
        }
      },
      success: function ( label, element ) {
        // Add the span element, if doesn't exists, and apply the icon classes to it.
        if ( !$( element ).next( "span" )[ 0 ] ) {
          $( "<span class='glyphicon glyphicon-ok form-control-feedback'></span>" ).insertAfter( $( element ) );
        }
      },
      submitHandler: function(form) {
        // do other things for a valid form
        swal({
          title: "Are you sure?",
          text: "Account information will be added to the database.",
          type: "warning",
          showCancelButton: true,
          confirmButtonText: "Yes, submit it!",
          cancelButtonText: "No, cancel it!",
          closeOnConfirm: false,
          closeOnCancel: false
        },
        function(isConfirm){
          if (isConfirm) {
            form.submit();
          } else {
            swal("Cancelled", "Registration Cancelled", "error");
          }
        })
      },
      highlight: function ( element, errorClass, validClass ) {
        $( element ).parents( ".form-group" ).addClass( "has-error" ).removeClass( "has-success" );
        $( element ).next( "span" ).addClass( "glyphicon-remove" ).removeClass( "glyphicon-ok" );
      },
      unhighlight: function ( element, errorClass, validClass ) {
        $( element ).parents( ".form-group" ).addClass( "has-success" ).removeClass( "has-error" );
        $( element ).next( "span" ).addClass( "glyphicon-ok" ).removeClass( "glyphicon-remove" );
      }
    } );
  });
</script>
