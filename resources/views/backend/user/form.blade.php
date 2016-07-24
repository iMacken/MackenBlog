<div class="form-group">
    {!! Form::label('name', '用户名') !!}
    {!! Form::text('name', null, ['class' => 'form-control','placeholder'=>'name']) !!}
    <font color="red">{{ $errors->first('name') }}</font>
</div>

<div class="form-group">
    {!! Form::label('email', '邮箱') !!}
    {!! Form::text('email', null, ['class' => 'form-control','placeholder'=>'Email']) !!}
    <font color="red">{{ $errors->first('email') }}</font>
</div>

<div class="form-group">
    {!! Form::label('password', '密码') !!}
    {!! Form::text('password', '', ['class' => 'form-control','placeholder'=>'password']) !!}
    <font color="red">{{ $errors->first('password') }}</font>
    <font>为空则不修改</font>
</div>

<div class="form-group">
    {!! Form::label('photo', '头像') !!}
    {!! Form::file('photo') !!}
    <font color="red">{{ $errors->first('photo') }}</font>
    <br />
    <div>
        @if(!empty($user->photo))
            <img class="thumbnail" src="{{ asset($user->photo) }}" width="300"/>
        @endif
    </div>
</div>

<div class="form-group">
    {!! Form::submit($submitBtnTxt, ['class' => 'btn btn-success col-md-12']) !!}
</div>