<div class="modal fade" id="editAccountModal" tabindex="-1" role="dialog" aria-labelledby="editAccountModal">
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
        <h3 style="color:#337ab7;">Update Account Information</h3>
      </div>
      <div class="modal-body">
          {{ Form::open(array('route'=>array('account.update'),'method'=>'PUT')) }}
          <input type="hidden" id="update-id" name="id" value="" />
          <div class="form-group">
            {{ Form::label('username','Username') }}
            {{ Form::text('username',Input::old('username'),[
                'class' => 'form-control',
                'id' => 'update-username',
                'placeholder' => 'Username'
            ])}}
            <p class="text-muted" style="font-size: 10px;"><span class="text-success">Note:</span>The Identification Number will be used as the username of the said person.</p>
          </div>
          <div class="form-group">
            {{ Form::label('firstname','Firstname') }}
            {{ Form::text('firstname',Input::old('firstname'),[
                'class' => 'form-control',
                'id' => 'update-firstname',
                'placeholder' => 'First name'
              ]) }}
          </div>
          <div class="form-group">
            {{ Form::label('middlename','Middlename') }}
            {{  Form::text('middlename',Input::old('middlename'),[
                  'class' => 'form-control',
                  'id' => 'update-middlename',
                  'placeholder' => 'Middle name'
                ])}}
          </div>
          <div class="form-group">
            {{ Form::label('lastname','Lastname') }}
             {{ Form::text('lastname',Input::old('lastname'),[
                'class' => 'form-control',
                'id' => 'update-lastname',
                'placeholder' => 'Last name'
             ]) }}
          </div>
          <div class="form-group">
            {{ Form::label('contactnumber','Mobile Number') }}
            {{ Form::text('contactnumber',Input::old('contactnumber'),[
                'class' => 'form-control',
                'id' => 'update-contactnumber',
                'placeholder' => 'Mobile Number'
            ]) }}
          </div>
          <div class="form-group">
            {{ Form::label('email','Email') }}
            {{ Form::text('email',Input::old('email'),[
                'class' => 'form-control',
                'id' => 'update-email',
                'placeholder' => 'Email'
            ]) }}
          </div>
          <div class="form-group">
            {{ Form::label('type','Role') }}
            {{ Form::select('type',[
              'assistant'=>'Laboratory Assistant',
              'staff'=>'Staff',
              'faculty'=>'Faculty',
              'student'=>'Student'
            ],Input::old('type'),[
              'class'=>'form-control',
              'id' => 'update-type'
            ]) }}
          </div>
          <div class="form-group">
            {{  Form::submit('Update',[
              'class' => 'btn btn-lg btn-primary btn-block'
            ]) }}
          </div>
          {{ Form::close() }}
      </div> <!-- end of modal-body -->
    </div> <!-- end of modal-content -->
  </div>
</div>
<script>
  $(document).ready(function(){

  });
</script>
