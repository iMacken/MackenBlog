<div class="form-group">
    {!! Form::label('name', '标签名') !!}
    {!! Form::text('name', null, ['class' => 'form-control','placeholder'=>'name']) !!}
    <font color="red">{{ $errors->first('name') }}</font>
</div>

<div class="form-group">
    {!! Form::label('slug', '别名') !!}
    {!! Form::text('slug', null, ['class' => 'form-control','placeholder'=>'slug']) !!}
    <font color="red">{{ $errors->first('slug') }}</font>
</div>

<div class="form-group">
    {!! Form::submit($submitBtnTxt, ['class' => 'btn btn-success col-md-12']) !!}
</div>
            