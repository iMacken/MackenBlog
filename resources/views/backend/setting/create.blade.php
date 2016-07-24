@extends('backend.app')

@section('content')
            <div class="panel panel-default">
                <div class="panel-heading">设置</div>

                @if ($errors->has('error'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <strong>Error!</strong>
                    {{ $errors->first('error', ':message') }}
                    <br />
                    请联系开发者！
                </div>
                @endif

                <div class="panel-body">
                    {!! Form::open(['url' => 'backend/setting/create', 'method' => 'POST']) !!}

                        <div class="form-group">
                            {!! Form::label('name', '键') !!}
                            {!! Form::text('name', null, ['class' => 'form-control','placeholder'=>'name']) !!}
                            <font color="red">{{ $errors->first('name') }}</font>
                        </div>

                        <div class="form-group">
                            {!! Form::label('value', '值') !!}
                            {!! Form::text('value', '', ['class' => 'form-control','placeholder'=>'value']) !!}
                            <font color="red">{{ $errors->first('value') }}</font>
                        </div>

                        <div class="form-group">
                            {!! Form::submit('完成', ['class' => 'btn btn-success col-md-12']) !!}
                        </div>

                    {!! Form::close() !!}
                </div>
            </div>
@endsection
