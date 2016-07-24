<div class="form-group">
    {!! Form::label('sort', '排序') !!}
    {!! Form::text('sort', null, ['class' => 'form-control','placeholder'=>'sort']) !!}
    <font color="red">{{ $errors->first('sort') }}</font>
</div>

<div class="form-group">
    {!! Form::label('name', '链接名称') !!}
    {!! Form::text('name', null, ['class' => 'form-control','placeholder'=>'name']) !!}
    <font color="red">{{ $errors->first('name') }}</font>
</div>

<div class="form-group">
    {!! Form::label('url', '链接地址') !!}
    {!! Form::text('url', null, ['class' => 'form-control','placeholder'=>'url']) !!}
    <font color="red">{{ $errors->first('url') }}</font>
</div>

<div class="form-group">
    {!! Form::submit($submitBtnTxt, ['class' => 'btn btn-success col-md-12']) !!}
</div>