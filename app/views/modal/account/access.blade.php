<div class="modal fade" id="changeAccessLevelModal" tabindex="-1" role="dialog" aria-labelledby="changeAccessLevelModal">
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
        <h3 style="color:#337ab7;">Change Access Level</h3>
      </div>
      <div class="modal-body">
        {{ Form::open(['method'=>'PUT','route'=>('account.accesslevel.update')]) }}
        <div class="form-group">
          {{ Form::label('accesslevel-id','ID') }}
          {{ Form::text('id',null,[
            'class'=>'form-control',
            'style' => 'background-color: white;',
            'id' => 'accesslevel-id',
            'readonly'
          ]) }}
        </div>
        <div class="form-group">
          {{ Form::label('accesslevel-name','Name') }}
          {{ Form::text('name',null,[
            'class'=>'form-control',
            'style' => 'background-color: white;',
            'id' => 'accesslevel-name',
            'readonly'
          ]) }}
        </div>
        <div class="form-group">
          {{ Form::label('accesslevel-oldaccesslevel','Current Access Level') }}
          {{ Form::text('oldaccesslevel',null,[
            'class'=>'form-control',
            'style' => 'background-color: white;',
            'id' => 'accesslevel-oldaccesslevel',
            'readonly'
          ]) }}
        </div>
        <label for="newaccesslevel">New Access Level</label>
        <div class="form-group">
          <ul class="list-group">
            @if(Auth::user()->accesslevel == 0)
            <li class="list-group-item">
              <div class="radio">
                <label>
                  <input type="radio" name="newaccesslevel" value="0">
                  Laboratory Head
                </label>
              </div>
            </li>
            @endif
            <li class="list-group-item">
              <div class="radio">
                <label>
                  <input type="radio" name="newaccesslevel" value="1">
                  Laboratory Assistant
                </label>
              </div>
            </li>
            <li class="list-group-item">
              <div class="radio">
                <label>
                  <input type="radio" name="newaccesslevel" value="2" checked>
                  Laboratory Staff
                </label>
              </div>
            </li>
            <li class="list-group-item">
              <div class="radio">
                <label>
                  <input type="radio" name="newaccesslevel" value="3">
                  Faculty
                </label>
              </div>
            </li>
            <li class="list-group-item">
              <div class="radio">
                <label>
                  <input type="radio" name="newaccesslevel" value="4">
                  Students
                </label>
              </div>
            </li>
          </ul>
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-primary btn-lg btn-block">Update</button>
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
